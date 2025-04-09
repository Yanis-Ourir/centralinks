<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;

class FormatApiReddit implements FormatApiDataInterface
{
    private LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function ApiCall(string $link) {
        $client = new \GuzzleHttp\Client();
        // $response = $client->get($link, [
        //     'headers' => [
        //         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
        //     ]
        // ]);
        // $data = json_decode($response->getBody(), true);
        // return $this->format($data['data']['children'] ?? []);
    }

    public function format(array $data): array
    {
        $formattedData = [];

        foreach ($data as $item) {
            if (isset($item['data'])) {
                $link = new Link();
                $link->setTitle($item['data']['title'] ?? '')
                     ->setUrl($item['data']['url'] ?? '')
                     ->setCreatedAt(new \DateTimeImmutable('@' . ($item['data']['created_utc'] ?? time())))
                     ->setUpdatedAt(new \DateTimeImmutable('@' . ($item['data']['created_utc'] ?? time())));

                $formattedData[] = $link;
            }
        }

        return $formattedData;
    }
}