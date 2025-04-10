<?php
namespace App\Service;

use App\Service\FormatApiFactory;
use App\Repository\LinkRepository;
use App\Service\FormatApiDataInterface;

class PostAggregator
{
    private FormatApiFactory $formatApi;
    private LinkRepository $linkRepository;

    public function __construct(FormatApiFactory $formatApi, LinkRepository $linkRepository)
    {
        $this->formatApi = $formatApi;
        $this->linkRepository = $linkRepository;
    }

    public function fetchAllPosts(): array
    {
        $posts = [];

        $links = $this->linkRepository->findAll();

        foreach ($links as $link) {
            /**
             * @var FormatApiDataInterface $formatter
             */
            $formatter = $this->formatApi->create($link->getApplicationName());
            $fetchedPost = $formatter->ApiCall($link->getUrl());

            if(is_array($fetchedPost)) {
                $posts[] = $fetchedPost;
            } 
        }

        return array_merge(...$posts);
    }
}
