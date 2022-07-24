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

        do {
            // Wait for 60 seconds until Github page creating file succeeds
            echo "Wait for 60 seconds until Github page creating file succeeds\n";
            sleep(60);
            $response = curl_exec($curl);
            $data = file_get_contents(json_decode($response)->package->url . '.json');
            $state = json_decode($data)?->package?->validations[0]?->state;
            if ($state === self::STATUS_VALID) {
                echo "Valid Csv File\n";
                break;
            } elseif ($state === self::STATUS_INVALID) {
                throw new Exception('Invalid Csv file');
            }
            echo "Retry validating\n";
        } while ($state === self::STATUS_NOT_FOUND);

        curl_close($curl);
    }
}
