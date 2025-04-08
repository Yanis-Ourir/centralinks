<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;
use GuzzleHttp\Client;

class FormatApiTwitter implements FormatApiDataInterface
{


    public function ApiCall(string $apiLink): void
    {
        dd($apiLink);
        $client = new Client();
        $response = $client->request('GET', $apiLink, [
            'header' => [
                'Authorization' => 'Bearer ' + $_ENV('ACCESS_TOKEN_TWITTER'),
                'client_id' => $_ENV('CLIENT_ID_TWITTER'),
                'client_secret' => $_ENV('CLIENT_SECRET_TWITTER'),
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $json = json_decode($body, true);
        $this->format($json);
    }

    public function format(array $data): array
    {
     

        // "data": [
        //     {
        //         "text": "lucina book https://t.co/d7cVubXSli",
        //         "id": "1908907475069538317",
        //         "edit_history_tweet_ids": [
        //             "1908907475069538317"
        //         ]
        //     }
        // ] JSON

        $testData = json_encode([
            'data' => [
            [
                'text' => 'lucina book https://t.co/d7cVubXSli',
                'id' => '1908907475069538317',
                'edit_history_tweet_ids' => [
                '1908907475069538317'
                ]
            ],
            [
                'text' => 'another tweet',
                'id' => '1908907475069538318',
                'edit_history_tweet_ids' => [
                '1908907475069538318'
                ]
            ]
            ]
        ]);

        $jsonData = json_decode($testData, true);


        return $this->getData($jsonData);
    }

    public function getData(array $data): array {
        //     0 => array:3 [▼
        //       "text" => "lucina book"
        //       "url" => "https://x.com/RotomDocs/status/1908907475069538317/photo/1"
        //       "id" => "1908907475069538317"
        //     ]
        //     1 => array:3 [▼
        //       "text" => "another tweet"
        //       "url" => "https://t.co/example"
        //       "id" => "1908907475069538318"
        //     ]

        $formattedData = [];
    
        foreach($data['data'] as $tweet) {
            if (!isset($tweet['text'])) {
                continue;
            }
            
            $text = $tweet['text'];
            preg_match('/(.+)\s+(https?:\/\/\S+)$/', $text, $matches);
            
            $formattedTweet = [
                'id' => $tweet['id'],
                'text' => $matches[1] ?? $text,
                'image' => $matches[2] ?? null,
            ];
            
            $formattedData[] = $formattedTweet;
        }
   
        
        return $formattedData;
    }
}