<?php

namespace App\Util\Service;

use Generator;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Util\Data\DataInterface;
use App\Util\Converter\ConverterFactory;
use App\Util\Service\GeocodingService;

class OrderFileConverterService
{
    /**
     * @var array
     */
    private const VALID_FORMATS = ['csv', 'xml', 'yaml'];

    /**
     * @var string
     */
    private const DISCOUNT_TYPE_DOLLAR = 'DOLLAR';

    /**
     * @var string
     */
    private const DISCOUNT_TYPE_PERCENTAGE = 'PERCENTAGE';

    /**
     * @var DataInterface
     */
    private DataInterface $dataInterface;

    /**
     * @var GeocodingService
     */
    private GeocodingService $geocodingService;

    /**
     * Construct
     *
     * @param DataInterface $dataInterface
     * @param GeocodingService $geocodingService
     */
    public function __construct(
        DataInterface $dataInterface,
        GeocodingService $geocodingService
    ) {
        $this->dataInterface = $dataInterface;
        $this->geocodingService = $geocodingService;
    }

    /**
     * Read File Line By Line
     *
     * @param string $fileName
     * @return Generator
     */
    private function readFileLineByLine(string $fileName): Generator
    {
        $file = fopen($fileName, 'r');
        while (($line = fgets($file)) !== false) {
            yield $line;
        }
        fclose($file);
    }

    /**
     * Convert Order Object To Order Data
     *
     * @param object $orderObject
     * @return DataInterface
     */
    public function convertOrderObjectToOrderData(object $orderObject): DataInterface
    {
        $totalOrderValue = 0;
        $totalQuantity = 0;
        foreach ($orderObject->items as $item) {
            $totalOrderValue += $item->unit_price * $item->quantity * 1.0;
            $totalQuantity += $item->quantity;
        }
        if ($totalOrderValue === 0 || $totalQuantity === 0) {
            return $this->dataInterface;
        }
        usort($orderObject->discounts, fn($a, $b) => $a->priority - $b->priority);
        foreach ($orderObject->discounts as $discount) {
            if ($discount->type === self::DISCOUNT_TYPE_DOLLAR) {
                $totalOrderValue -= $discount->value;
            } elseif ($discount->type === self::DISCOUNT_TYPE_PERCENTAGE) {
                $totalOrderValue *= (100.0 - $discount->value) / 100.0;
            }
        }
        $averageUnitPrice = $totalOrderValue / $totalQuantity;

        $address = $orderObject->customer?->shipping_address?->street ?? ''
            + ' ' + $orderObject->customer?->shipping_address?->suburb ?? ''
            + ' ' + $orderObject->customer?->shipping_address?->state ?? ''
            + ' ' + $orderObject->customer?->shipping_address?->postcode ?? '';
        $geocoding = $this->geocodingService->getGeocoding($address);

        $this->dataInterface->setOrderId($orderObject->order_id);
        $this->dataInterface->setOrderDateTime($orderObject->order_date);
        $this->dataInterface->setTotalOrderValue(round($totalOrderValue, 2));
        $this->dataInterface->setAverageUnitPrice(round($averageUnitPrice, 2));
        $this->dataInterface->setDistinctUnitCount(count($orderObject->items));
        $this->dataInterface->setTotalUnitsCount($totalQuantity);
        $this->dataInterface->setCustomerState($orderObject->customer?->shipping_address?->state);
        $this->dataInterface->setLatitude($geocoding['latitude']);
        $this->dataInterface->setLongitude($geocoding['longitude']);

        return $this->dataInterface;
    }

    /**
     * Convert Order File
     *
     * @param string $jsonlFileName
     * @param string $outputFileName
     * @return void
     */
    public function convertOrderFile(string $jsonlFileName, string $outputFileName): void
    {
        $fileNameInfo = explode('.', $outputFileName);
        if (
            !str_contains($outputFileName, '.')
            || empty(end($fileNameInfo))
            || !in_array(end($fileNameInfo), self::VALID_FORMATS)
        ) {
            throw new Exception('Invalid file format');
        }

        $converterInterface =
            ConverterFactory::createConverter(end($fileNameInfo));

        $file = fopen($outputFileName, 'w');
        fwrite($file, $converterInterface->getHeader($this->dataInterface));
        foreach ($this->readFileLineByLine($jsonlFileName) as $orderObjectString) {
            $this->convertOrderObjectToOrderData(json_decode((string)$orderObjectString));
            // Order records with 0 total order value should be excluded from the summary output.
            if ($this->dataInterface->getTotalOrderValue() <= 0) {
                continue;
            }
            fwrite($file, "\r\n");
            fwrite($file, $converterInterface->convert($this->dataInterface));
        }
        if ($converterInterface->getFooter() !== '') {
            fwrite($file, $converterInterface->getFooter());
        }
        fclose($file);
    }
}
