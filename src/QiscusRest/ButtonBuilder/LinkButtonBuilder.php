<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/17/18
 * Time: 12:06 PM
 */

namespace QiscusRest\ButtonBuilder;


class LinkButtonBuilder implements ButtonBuilder
{
    private $label, $url, $payload;
    public function __construct(string $label, string $url, string $payload = '')
    {
        $this->label = $label;
        $this->url = $url;
        $this->payload = $payload;

    }

    public function build()
    {
        return [
            'label'     => $this->label,
            'type'      => 'link',
            'payload'   => [
                'url'       => $this->url,
                'method'    => 'get',
                'payload'   => $this->payload,
            ]
        ];
    }
}