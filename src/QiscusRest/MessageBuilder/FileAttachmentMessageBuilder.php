<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/11/18
 * Time: 11:19 AM
 */

namespace QiscusRest\MessageBuilder;


class FileAttachmentMessageBuilder implements MessageBuilder
{
    private $url;
    private $caption;
    private $extras;
    /**
     * TextMessageBuilder constructor.
     * @param string $url
     * @param string $caption
     */
    public function __construct(string $url, string $caption= '', $extras = [])
    {
        $this->url = $url;
        $this->caption = $caption;
    }

    public function buildMessage()
    {
        return [
            'type'      => 'file_attachment',
            'payload'   => [
                'url'       => $this->url,
                'caption'   => $this->caption,
            ],
        ];
    }
}