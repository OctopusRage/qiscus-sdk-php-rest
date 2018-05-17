<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/17/18
 * Time: 11:27 AM
 */

namespace QiscusRest\ButtonBuilder;

class PostbackButtonBuilder implements ButtonBuilder
{
    private $label, $url, $method, $payload;

    public function __construct(string $label, string $url, string $method, string $payload = ''){
        $this->label = $label;
        $this->url = $url;
        $this->method = $method;
        $this->payload = $payload;
    }

    public function build()
    {
        return [
            'label'     => $this->label,
            'type'      => 'postback',
            'payload'   => [
                'url'       => $this->url,
                'method'    => $this->method,
                'payload'   => $this->payload,
            ]
        ];
    }
}