<?php
namespace App\Service;

use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class FormatApiTwitter implements FormatApiDataInterface
{


    public function ApiCall(string $apiLink): array
    {
        $cache = new FilesystemAdapter();
        $twitterData = $cache->getItem('twitter_data');
        
        if ($twitterData->isHit()) {
            return $this->format($twitterData->get());
        }
        
        $client = new Client();
        $response = $client->request('GET', $apiLink, [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['ACCESS_TOKEN_TWITTER'],
            ]
        ]);
        
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error fetching data from Twitter API: ' . $response->getReasonPhrase());
        }

        $json = json_decode($response->getBody(), true);

        $twitterData->set($json);
        $twitterData->expiresAfter(3600); // 1 HEURE
        $cache->save($twitterData);

        
        return $this->format($json);
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
                'applicationName' => 'twitter',
            ];
            
            $formattedData[] = $formattedTweet;
        }
   

        return $formattedData;
    }

}