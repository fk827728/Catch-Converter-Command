<?php

namespace App\Util\Data;

class OrderData implements DataInterface
{
    /**
     * @var int
     */
    public int $orderId;

    /**
     * @var string
     */
    public string $orderDateTime;

    /**
     * @var float
     */
    public float $totalOrderValue;

    /**
     * @var float
     */
    public float $averageUnitPrice;

    /**
     * @var int
     */
    public int $distinctUnitCount;

    /**
     * @var int
     */
    public int $totalUnitsCount;

    /**
     * @var string
     */
    public string $customerState;

    /**
     * @var float
     */
    public float $latitude;

    /**
     * @var float
     */
    public float $longitude;

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->orderId = 0;
        $this->orderDateTime = '';
        $this->totalOrderValue = 0;
        $this->averageUnitPrice = 0;
        $this->distinctUnitCount = 0;
        $this->totalUnitsCount = 0;
        $this->customerState = '';
        $this->latitude = 0;
        $this->longitude = 0;
    }

    /**
     * Set Order Id
     *
     * @param int $orderId
     * @return void
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Get Order Id
     *
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * Set Order Date Time
     *
     * @param string $orderDateTime
     * @return void
     */
    public function setOrderDateTime(string $orderDateTime): void
    {
        $this->orderDateTime = $orderDateTime;
    }

    /**
     * Get Order Date Time
     *
     * @return string
     */
    public function getOrderDateTime(): string
    {
        return $this->orderDateTime;
    }

    /**
     * Set Total Order Value
     *
     * @param float $totalOrderValue
     * @return void
     */
    public function setTotalOrderValue(float $totalOrderValue): void
    {
        $this->totalOrderValue = $totalOrderValue;
    }

    /**
     * Get Total Order Value
     *
     * @return float
     */
    public function getTotalOrderValue(): float
    {
        return $this->totalOrderValue;
    }

    /**
     * Set Average Unit Price
     *
     * @param float $averageUnitPrice
     * @return void
     */
    public function setAverageUnitPrice(float $averageUnitPrice): void
    {
        $this->averageUnitPrice = $averageUnitPrice;
    }

    /**
     * Get Average Unit Price
     *
     * @return float
     */
    public function getAverageUnitPrice(): float
    {
        return $this->averageUnitPrice;
    }

    /**
     * Set Distinct Unit Count
     *
     * @param int $distinctUnitCount
     * @return void
     */
    public function setDistinctUnitCount(int $distinctUnitCount): void
    {
        $this->distinctUnitCount = $distinctUnitCount;
    }

    /**
     * Get Distinct Unit Count
     *
     * @return int
     */
    public function getDistinctUnitCount(): int
    {
        return $this->distinctUnitCount;
    }

    /**
     * Set Total Units Count
     *
     * @param int $totalUnitsCount
     * @return void
     */
    public function setTotalUnitsCount(int $totalUnitsCount): void
    {
        $this->totalUnitsCount = $totalUnitsCount;
    }

    /**
     * Get Total Units Count
     *
     * @return int
     */
    public function getTotalUnitsCount(): int
    {
        return $this->totalUnitsCount;
    }

    /**
     * Set Customer State
     *
     * @param string $customerState
     * @return void
     */
    public function setCustomerState(string $customerState): void
    {
        $this->customerState = $customerState;
    }

    /**
     * Get Customer State
     *
     * @return string
     */
    public function getCustomerState(): string
    {
        return $this->customerState;
    }

    /**
     * Set Latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Get Latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Set Longitude
     *
     * @param float $longitude
     * @return void
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Get Longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
