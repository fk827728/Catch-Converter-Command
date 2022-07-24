<?php

namespace App\Util\Converter;

use App\Util\Service\StringService;
use App\Util\Data\DataInterface;

class XmlConverter implements ConverterInterface
{
    /**
     * Get Header
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function getHeader(DataInterface $dataInterface): string
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<orders>";
    }

    /**
     * Get Footer
     *
     * @return string
     */
    public function getFooter(): string
    {
        return "\r\n</orders>";
    }

    /**
     * Convert
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function convert(DataInterface $dataInterface): string
    {
        $result = '';
        $result .= "<order>\r\n";
        foreach ($dataInterface as $key => $value) {
            $key = StringService::toSnakeString($key);
            $result .= '<' . $key . '>';
            $result .= $value;
            $result .= '</' . $key . '>';
            $result .= "\r\n";
        }
        $result .= "</order>";

        return $result;
    }
}
