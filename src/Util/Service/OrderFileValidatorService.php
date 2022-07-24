<?php

namespace App\Util\Service;

use App\Util\Validator\ValidatorFactory;

class OrderFileValidatorService
{
    /**
     * Validate
     *
     * @param string $fileName
     * @return void
     */
    public function validate(string $fileName): void
    {
        $fileNameInfo = explode('.', $fileName);
        $validatorInterface = ValidatorFactory::createValidator(end($fileNameInfo));
        $validatorInterface->validate($fileName);
    }
}
