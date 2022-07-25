<?php

namespace App\Util\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UploadService
{
    private ParameterBagInterface $parameterBagInterface;
    private HttpClientInterface $httpClientInterface;

    /**
     * Construct
     *
     * @param ParameterBagInterface $parameterBagInterface
     * @param HttpClientInterface $httpClientInterface
     */
    public function __construct(
        ParameterBagInterface $parameterBagInterface,
        HttpClientInterface $httpClientInterface
    ) {
        $this->parameterBagInterface = $parameterBagInterface;
        $this->httpClientInterface = $httpClientInterface;
    }

    /**
     * Upload to Github and share with Github page
     *
     * @param string $fileName
     * @return string
     */
    public function upload(string $fileName): string
    {
        $githubApiUrl = $this->parameterBagInterface->get('github_api_url');
        $githubApiToken = $this->parameterBagInterface->get('github_api_token');
        $githubFilePath = $this->parameterBagInterface->get('github_file_path');

        $fileNameInfo = explode('\\', $fileName);
        $url = $githubApiUrl . end($fileNameInfo);
        $headers = [
            'Authorization' => 'token ' . $githubApiToken
        ];
        $body = [
            'message' => 'File validation',
            'content' => base64_encode(file_get_contents($fileName))
        ];

        // Remove try-catch to show the true error message
        $this->httpClientInterface->request(
            'PUT',
            $url,
            [
                'headers' => $headers,
                'json' => $body
            ]
        );

        return $githubFilePath . end($fileNameInfo);
    }
}
