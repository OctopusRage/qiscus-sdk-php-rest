<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/17/18
 * Time: 1:14 PM
 */

namespace QiscusRest\MessageBuilder;


class ButtonMessageBuilder implements MessageBuilder
{
    private $text, $buttons;
    public function __construct(string $text, array $buttons)
    {
        if(sizeof($buttons) <1) throw new \Exception('must be array of buttons');
        if(!($buttons[0] instanceof \QiscusRest\ButtonBuilder\ButtonBuilder)) {
            throw new \Exception('must be array of buttons');
        }
        $this->text = $text;
        foreach ($buttons as $button) {
            $this->buttons[] = $button->build();
        }
    }


    public function buildMessage()
    {
        return [
            'type'      => 'buttons',
            'payload'   => [
                'text'      => $this->text,
                'buttons'   => $this->buttons,
            ]
        ];
    }
}