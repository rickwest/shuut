<?php

namespace App\DistanceMatrix;

use App\Entity\Address;
use App\Entity\Distance;
use GuzzleHttp\Client;


class GoogleMapsDistanceMatrix implements DistanceMatrixInterface
{
    private $client;

    private $googleMapsApiKey;

    public function __construct(Client $client, string $googleMapsApiKey)
    {
        $this->client = $client;
        $this->googleMapsApiKey = $googleMapsApiKey;
    }

    public function getDistance(Address $origin, Address $destination)
    {
        $url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?key=' . $this->googleMapsApiKey;
        $url .= '&origins=' . urlencode($origin->__toString());
        $url .= '&destinations=' . urlencode($destination->__toString());
        $url .= '&units=imperial';
        $url .= '&mode=driving';

        try {
            $res = $this->client->get($url);
        } catch (\Exception $exception) {
            return null;
        }

        $distance = json_decode($res->getBody()->getContents(), true);

        if (! array_key_exists('rows', $distance) || count($distance['rows']) === 0) {
            return null;
        }

        return new Distance(
            $distance['rows'][0]['elements'][0]['distance']['value'],
            $distance['rows'][0]['elements'][0]['duration']['value']
        );
    }

    public function getMap(Address $origin, Address $destination)
    {
        $mapUrl = 'https://www.google.com/maps/embed/v1/directions?key=' . $this->googleMapsApiKey;
        $mapUrl.= '&mode=driving';
        $mapUrl.= '&origin=' . urlencode($origin->__toString());
        $mapUrl.= '&destination=' . urlencode($destination->__toString());
        $mapUrl.= '&units=imperial';

        return $mapUrl;
    }
}