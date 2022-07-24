<?php

namespace App\Util\Validator;

class ValidatorFactory
{
    /**
     * Create Validator
     *
     * @param string $format
     * @return ValidatorInterface
     */
    public static function createValidator(string $format): ValidatorInterface
    {
        $className = 'App\\Util\\Validator\\' . ucfirst($format) . 'Validator';
        return new $className();
    }
}
