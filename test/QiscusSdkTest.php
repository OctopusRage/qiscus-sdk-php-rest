<?php

require 'vendor/autoload.php';
use QiscusRest\QiscusSDK;
$client = new QiscusSDK('check', 'rahasiabanget');
$login = $client->loginOrRegister('ahyana1995@gmail.com','password');
//var_dump($login);
$profile = $client->userProfile('ahyana1995@gmail.com');
//var_dump($profile);
$room = $client->getOrCreateRoom(['ahyana1995@gmail.com','check_admin@qismo.com']);

$messageBuilder = new \QiscusRest\MessageBuilder\TextMessageBuilder('hello');
try {
    $postComment = $client->postComment('ahyana1995@gmail.com', $room->room_id, $messageBuilder);
    echo 'SUCCESS POST COMMENT TEXT</br>';
} catch (\Exception $e) {
    var_dump('FAILED POST COMMENT TEXT'. $e->getMessage(). ' '.$e->getCode());
}

$messageBuilder = new \QiscusRest\MessageBuilder\FileAttachmentMessageBuilder('http://watchlab.com/blog/wp-content/uploads/2015/03/slack-logo.png');
try {
    $postComment = $client->postComment('ahyana1995@gmail.com', $room->room_id, $messageBuilder);
    echo 'SUCCESS POST COMMENT FILE ATTACHMENT</br>';
} catch (\Exception $e) {
    var_dump('FAILED POST COMMENT TEXT'. $e->getMessage(). ' '.$e->getCode());
}


$button1 = new QiscusRest\ButtonBuilder\PostbackButtonBuilder('btn1', 'https://www.google.com', 'get');
$button2 = new QiscusRest\ButtonBuilder\LinkButtonBuilder('btn2', 'https://www.google.com');
$buttons = [$button1, $button2];
$messageBuilder = new \QiscusRest\MessageBuilder\CardMessageBuilder('hello selamat datang', 'https://cdn0.iconfinder.com/data/icons/social-15/200/mail-icon-128.png','no body cares', 'ini adalah ....' ,'https://www.google.com', $buttons);
try {
    $postComment = $client->postComment('ahyana1995@gmail.com', $room->room_id, $messageBuilder);
    echo 'SUCCESS POST COMMENT FILE ATTACHMENT</br>';
} catch (\Exception $e) {
    var_dump('FAILED POST COMMENT TEXT'. $e->getMessage(). ' '.$e->getCode());
}

echo json_encode($messageBuilder->buildMessage());