<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;

class FormatApiTwitter implements FormatApiDataInterface
{
    private LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
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