<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use App\Service\FormatApiFactory;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
final class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(CategoryRepository $categoryRepository, FormatApiFactory $formatApi, LinkRepository $linkRepository): Response
    {
        $user = $this->getUser();
        $categories = $categoryRepository->findBy(['owner' => $user]);
        $posts = [];
        $links = $linkRepository->findAll();
        foreach ($links as $link) {
            /**
             * @var FormatApiDataInterface $factoryClass
             */
            $factoryClass = $formatApi->create($link->getApplicationName());
            $posts[] = $factoryClass->ApiCall($link->getUrl());
        }

        
        
        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
