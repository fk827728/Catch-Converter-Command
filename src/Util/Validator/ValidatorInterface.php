<?php

namespace App\Util\Validator;

interface ValidatorInterface
{
    /**
     * Validate
     *
     * @param string $fileName
     * @return void
     */
    public function validate(string $fileName): void;
}
