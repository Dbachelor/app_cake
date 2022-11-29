<?php

namespace App\Service;

use App\Rabbit\MessagingProducer;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessageService
{
    private $messagingProducer;


    public function createMessage()
    {
        $count = 0;
        $news = json_decode($this->curlService(), true);
        $articles = $news['articles'];
        $total = count($articles);
        $this->arr = [];
        for ($i=0; $i<$total; $i++) {
            $message = [
                'title' => $articles[$i]['title'],
                'description' => $articles[$i]['description'],
                'urtToImage' => $articles[$i]['urlToImage'],
                'publishedAt' => $articles[$i]['publishedAt']
            ];
            array_push($this->arr, $message);
           
        }

        return $this->arr;
    }


    private function curlService(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://newsapi.org/v2/everything?apiKey=cc2c369925cf406baf459d95462cc9cb&q=coin',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array(
            'User-Agent: 1234',
            'Accept: Application/json',
            'Content-type: Application/json'
          ),
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}