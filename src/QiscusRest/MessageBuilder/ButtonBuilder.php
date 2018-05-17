<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/11/18
 * Time: 3:55 PM
 */

namespace QiscusRest\MessageBuilder;


class ButtonBuilder
{
    private $label, $url, $method, $payload;

    public function postBack(string $label, string $url, string $method, string $payload = ''){
        return [
            'label'     => $label,
            'type'      => 'postback',
            'payload'   => [
                'url'       => $url,
                'method'    => $method,
                'payload'   => $payload,
            ]
        ];
    }

    public function link(string $label, string $url, string $payload = ''){
        return [
            'label'     => $label,
            'type'      => 'postback',
            'payload'   => [
                'url'       => $url,
                'payload'   => $payload,
            ]
        ];
    }

}