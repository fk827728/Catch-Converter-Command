<?php

namespace App\Util\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GeocodingService
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBagInterface;

    /**
     * Construct
     *
     * @param ParameterBagInterface $parameterBagInterface
     */
    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->parameterBagInterface = $parameterBagInterface;
    }

    /**
     * Get Geocoding
     *
     * @param string $address
     * @return array
     */
    public function getGeocoding(string $address): array
    {
        $googleMapApiKey = $this->parameterBagInterface->get('google_map_api_key');

        $prepAddr = str_replace(' ', '+', $address);
        $url = 'https://maps.google.com/maps/api/geocode/json?address=' .
            $prepAddr . '&sensor=false&key=' . $googleMapApiKey;

        $response = file_get_contents($url);

        $latitude = json_decode($response)?->results[0]?->geometry?->location?->lat ?? 0;
        $longitude = json_decode($response)?->results[0]?->geometry?->location?->lng ?? 0;

        return [
            'latitude' => $latitude,
            'longitude' => $longitude
        ];
    }
}
