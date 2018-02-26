<?php

require 'vendor/autoload.php';
use QiscusRest\QiscusSDK;
$client = new QiscusSDK('check', 'rahasiabanget');
$login = $client->loginOrRegister('ahyana1995@gmail.com','password');
var_dump($login);
$profile = $client->userProfile('ahyana1995@gmail.com');
var_dump($profile);
$room = $client->getOrCreateRoom(['ahyana1995@gmail.com','check_admin@qismo.com']);

$messageBuilder = new \QiscusRest\MessageBuilder\TextMessageBuilder('hello');
$postComment = $client->postComment('ahyana1995@gmail.com', $room->room_id, $messageBuilder);
//var_dump($postComment);