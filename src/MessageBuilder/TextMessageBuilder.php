<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 2/13/18
 * Time: 2:21 PM
 */

namespace QiscusRest\MessageBuilder;


class TextMessageBuilder implements MessageBuilder
{
    private $message;
    private $extras;
    /**
     * TextMessageBuilder constructor.
     * @param $message
     * @param string $extras
     */
    public function __construct(string $message, $extras = '')
    {
        $this->message = $message;
        $this->extras = $extras;
    }

    public function buildMessage() {
        return  [
            'message' => $this->message,
            'extras' => $this->extras,
        ];
    }
}