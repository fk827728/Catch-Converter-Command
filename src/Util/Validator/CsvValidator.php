<?php

namespace App\Util\Validator;

use Exception;

class CsvValidator implements ValidatorInterface
{
    /**
     * @var string
     */
    private const CSVLINT_URL = 'http://csvlint.io/package.json';

    /**
     * @var string
     */
    private const STATUS_VALID = 'valid';

    /**
     * @var string
     */
    private const STATUS_INVALID = 'invalid';

    /**
     * @var string
     */
    private const STATUS_NOT_FOUND = 'not_found';

    /**
     * Validate
     *
     * @param string $fileName
     * @return void
     */
    public function validate(string $fileName): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::CSVLINT_URL);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'urls[]=' . $fileName);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $retryCount = 0;
        $state = self::STATUS_NOT_FOUND;
        do {
            // Wait for 60 seconds until Github page creating file succeeds
            echo "Wait for 60 seconds until Github page creating file succeeds\n";
            sleep(60);
            $response = curl_exec($curl);
            $data = file_get_contents(json_decode($response)->package->url . '.json');
            $validations = json_decode($data)?->package?->validations;
            if (!$validations || count($validations) === 0) {
                echo "Validations is empty. Retry validating\n";
                continue;
            }
            $state = $validations[0]?->state;
            if (isset($state) && $state === self::STATUS_VALID) {
                echo "Valid Csv File\n";
                break;
            } elseif (isset($state) && $state === self::STATUS_INVALID) {
                throw new Exception('Invalid Csv file');
            }
            $retryCount++;
            if ($retryCount > 5) {
                echo "Retry more than 5 times\n";
                break;
            }
            echo "Github shared csv file not found. Retry validating\n";
        } while (!isset($state) || $state === self::STATUS_NOT_FOUND);

        if (!isset($state) || $state !== self::STATUS_VALID) {
            throw new Exception('Invalid Csv file');
        }

        curl_close($curl);
    }
}
