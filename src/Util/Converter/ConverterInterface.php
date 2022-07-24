<?php

namespace App\Util\Converter;

use App\Util\Data\DataInterface;

interface ConverterInterface
{
    /**
     * Get Header
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function getHeader(DataInterface $dataInterface): string;

    /**
     * Get Footer
     *
     * @return string
     */
    public function getFooter(): string;

    /**
     * Convert
     *
     * @param DataInterface $dataInterface
     * @return string
     */
    public function convert(DataInterface $dataInterface): string;
}
