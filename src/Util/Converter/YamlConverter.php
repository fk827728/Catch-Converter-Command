<?php

namespace App\Util\Converter;

use App\Util\Service\StringService;
use App\Util\Data\DataInterface;

class YamlConverter implements ConverterInterface
{
    /**
     * Get Header
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function getHeader(DataInterface $dataInterface): string
    {
        return "orders:";
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
        $keyValues = [];
        foreach ($dataInterface as $key => $value) {
            $key = StringService::toSnakeString($key);
            $keyValues[] = $key . ': ' . $value;
        }

        $result = '';
        $result .= "\t";
        $result .= '- {';
        $result .= implode(',', $keyValues);
        $result .= '}';

        return $result;
    }
}
