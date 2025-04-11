<?php

namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;

class FormatApiReddit implements FormatApiDataInterface
{

    public function ApiCall(string $apiLink): array
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $apiLink, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $json = json_decode($body, true);
        return $this->format($json);
    }

    public function format(array $data): array
    {
        $formattedData = [];

        if (!isset($data['data']['children'])) {
            return $formattedData;
        }

        foreach ($data['data']['children'] as $child) {
            $post = $child['data'];

            $formattedData[] = [
                'title' => $post['title'] ?? '',
                'author' => $post['author'] ?? '',
                'url' => $post['url'] ?? '',
                'permalink' => 'https://www.reddit.com' . ($post['permalink'] ?? ''),
                'created_utc' => date('Y-m-d H:i:s', $post['created_utc'] ?? 0),
                'score' => $post['score'] ?? 0,
                'num_comments' => $post['num_comments'] ?? 0,
                'selftext' => $post['selftext'] ?? '',
                'subreddit' => $post['subreddit'] ?? '',
                'thumbnail' => (isset($post['thumbnail']) && filter_var($post['thumbnail'], FILTER_VALIDATE_URL)) ? $post['thumbnail'] : null,
                'flair' => $post['link_flair_text'] ?? null,
                'applicationName' => 'reddit',
            ];
        }

    
        return $formattedData;
    }
}
