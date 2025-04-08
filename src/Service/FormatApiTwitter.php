<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;
use GuzzleHttp\Client;

class FormatApiTwitter implements FormatApiDataInterface
{


    public function ApiCall(string $apiLink): void
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.x.com/2/users/1324000847236419584/tweets?max_results=5&exclude=retweets,replies', [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['ACCESS_TOKEN_TWITTER'],
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $json = json_decode($body, true);
        $this->format($json);
    }

    public function format(array $data): array
    {
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
   
        dd($formattedData);
        return $formattedData;
    }

}