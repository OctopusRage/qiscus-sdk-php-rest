<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/17/18
 * Time: 1:31 PM
 */

namespace QiscusRest\MessageBuilder;

class LocationMessageBuilder implements  MessageBuilder
{
    private $name, $address, $latitude, $longitude, $mapUrl;
    public function __construct($name, $address, $latitude, $longitude, $mapUrl)
    {
        $this->name = $name;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->mapUrl = $mapUrl;
    }

    public function buildMessage()
    {
        return [
            'type'      => 'location',
            'payload'   => [
                'name'      => $this->name,
                'address'   => $this->address,
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
                'map_url'   => $this->mapUrl,
            ]
        ];
    }
}