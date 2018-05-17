<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 5/11/18
 * Time: 11:19 AM
 */

namespace QiscusRest\MessageBuilder;


/**
 * Class CardMessageBuilder
 * @package QiscusRest\MessageBuilder
 */
class CardMessageBuilder implements MessageBuilder
{
    private $url, $imageUrl, $title, $description, $text, $buttons =[];


    /**
     * CardMessageBuilder constructor.
     * @param string $text
     * @param string $imageUrl
     * @param string $title
     * @param string $description
     * @param string $url
     * @param array $buttons
     * @throws \Exception
     */
    public function __construct(string $text, string $imageUrl, string $title, string $description, string $url, array $buttons)
    {
        if(sizeof($buttons) <1) throw new \Exception('must be array of buttons');
        if(!($buttons[0] instanceof \QiscusRest\ButtonBuilder\ButtonBuilder)) {
            throw new \Exception('must be array of buttons');
        }
        $this->url = $url;
        $this->text = $text;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;

        foreach ($buttons as $button) {
            $this->buttons[] = $button->build();
        }
    }

    public function buildMessage()
    {

        return [
            'type'      => 'card',
            'payload'   => [
                'text'          => $this->text,
                'image'         => $this->imageUrl,
                'title'         => $this->title,
                'description'   => $this->description,
                'url'           => $this->url,
                'buttons'       => $this->buttons,
            ],
        ];
    }
}