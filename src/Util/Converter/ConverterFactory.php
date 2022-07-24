<?php

namespace App\Util\Converter;

class ConverterFactory
{
    /**
     * Create Converter
     *
     * @param string $format
     * @return ConverterInterface
     */
    public static function createConverter(string $format): ConverterInterface
    {
        $className = 'App\\Util\\Converter\\' . ucfirst($format) . 'Converter';
        return new $className();
    }
}
