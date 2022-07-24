<?php

namespace App\Util\Converter;

use App\Util\Service\StringService;
use App\Util\Data\DataInterface;

class CsvConverter implements ConverterInterface
{
    /**
     * Get Header
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function getHeader(DataInterface $dataInterface): string
    {
        $keys = [];
        foreach ($dataInterface as $key => $value) {
            $keys[] = StringService::toSnakeString($key);
        }

        return implode(',', $keys);
    }

    /**
     * Get Footer
     *
     * @return string
     */
    public function getFooter(): string
    {
        return '';
    }

    /**
     * Convert
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function convert(DataInterface $dataInterface): string
    {
        $values = [];
        foreach ($dataInterface as $key => $value) {
            $values[] = $value;
        }

        return implode(',', $values);
    }
}
