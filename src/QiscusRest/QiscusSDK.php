<?php
/**
 * Created by PhpStorm.
 * User: octopus
 * Date: 2/13/18
 * Time: 2:19 PM
 */
namespace QiscusRest;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use QiscusRest\MessageBuilder\MessageBuilder;

class QiscusSDK
{
    private $appId;
    private $secretKey;
    private $httpClient;
    public function __construct(string $appId, string $secretKey)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
        $this->httpClient = new Client(['base_uri' => 'https://' . $appId.'.qiscus.com']);
    }


    public function loginOrRegister(string $userId, string $userName, string $password = null, string $avatarUrl = null){
        try{
            $payload = [
                'user_id'       => $userId,
                'password'      => $password,
                'username'      => $userName,
                'avatar_url'    => $avatarUrl,
            ];
            $response = $this->httpRequestPost('api/v2.1/rest/login_or_register', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->user;
    }

    public function userProfile(string $userId){
        try{
            $payload = [
                'user_id' => $userId,
            ];
            $response = $this->httpRequestGet('api/v2.1/rest/user_profile', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->user;
    }


    public function chatWithTarget(string $userId, string $destinationEmail, MessageBuilder $messageBuilder){
        try{
            $room = $this->getOrCreateRoom([$userId, $destinationEmail]);
            $payload = array_merge(
                [
                    'user_id' => $userId,
                    'room_id' => $room->room_id
                ],
                $messageBuilder->buildMessage()
            );
            $response = $this->httpRequestPost('api/v2.1/post_comment', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->comment;
    }

    public function chatToRoom(string $userId, string $roomId, MessageBuilder $messageBuilder){
        try{
            $payload = array_merge(
                [
                    'user_id' => $userId,
                    'room_id' => $roomId
                ],
                $messageBuilder->buildMessage()
            );
            $response = $this->httpRequestPost('api/v2.1/post_comment', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->comment;
    }

    public function getOrCreateRoom(array $emails, array $options = []){
        $payload = [
            'user_ids' => $emails,
            'room_options' => json_encode($options)
        ];
        try{
            $response = $this->httpRequestPost('/api/v2.1/rest/get_or_create_room_with_target', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->room;
    }

    public function postComment(string $userId, string $roomId, MessageBuilder $messageBuilder){
        try{
            $payload = array_merge(
                [
                    'user_id' => $userId,
                    'room_id' => $roomId
                ],
                $messageBuilder->buildMessage()
            );
            var_dump($payload);
            $response = $this->httpRequestPost('api/v2.1/rest/post_comment', $payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $response->comment;
    }

    private function httpRequestPost(string $uri, array $payload){
        try{
            $response = $this->httpClient->post($uri, [
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'QISCUS_SDK_APP_ID' => $this->appId,
                    'QISCUS_SDK_SECRET' => $this->secretKey
                ],
                RequestOptions::JSON => $payload
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
            // docs.guzzlephp.org/en/latest/quickstart.html#exceptions
            // for 500-level errors or 400-level errors
            $response_body = $exception->getResponse()->getBody(true);
            $response_json = json_decode((string) $response_body);

            $errors = '';
            $statusCode = $exception->getResponse()->getStatusCode();
            if($statusCode==404){
                throw new \Exception('Page not found', $statusCode);
            }
            if(!empty($response_json->error)) {
                if (property_exists($response_json->error, 'detailed_messages')) {
                    $errors = join(', ', $response_json->error->detailed_messages);
                }
            }

            if(empty($errors)) $errors = 'Something went wrong';

            var_dump($statusCode);
            throw new \Exception($errors, $statusCode);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return json_decode($response->getBody())->results;
    }

    private function httpRequestGet(string $uri, array $payload){
        try{
            $response = $this->httpClient->get($uri, [
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'QISCUS_SDK_APP_ID' => $this->appId,
                    'QISCUS_SDK_SECRET' => $this->secretKey
                ],
                RequestOptions::QUERY => $payload
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
            // docs.guzzlephp.org/en/latest/quickstart.html#exceptions
            // for 500-level errors or 400-level errors
            $response_body = $exception->getResponse()->getBody(true);
            $response_json = json_decode((string) $response_body);

            $errors = '';
            $statusCode = $exception->getResponse()->getStatusCode();
            if($statusCode==404){
                throw new \Exception('Page not found', $statusCode);
            }
            if(!empty($response_json->error)) {
                if (property_exists($response_json->error, 'detailed_messages')) {
                    $errors = join(', ', $response_json->error->detailed_messages);
                }
            }

            if(empty($errors)) $errors = 'Something went wrong';

            var_dump($statusCode);
            throw new \Exception($errors, $statusCode);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return json_decode($response->getBody())->results;
    }

}