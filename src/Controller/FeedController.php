<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\FormatApiTwitter;


#[IsGranted('ROLE_USER')]
final class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(CategoryRepository $categoryRepository, FormatApiTwitter $formatApi, LinkRepository $linkRepository): Response
    {
        $user = $this->getUser();
        $categories = $categoryRepository->findBy(['owner' => $user]);
        $posts = [];
        $links = $linkRepository->findAll();
        foreach ($links as $link) {
            $posts[] = [
                'title' => $link->getTitle(),
                'url' => $link->getUrl(),
                'createdAt' => $link->getCreatedAt(),
                'updatedAt' => $link->getUpdatedAt(),
            ];
        }

        dd($posts);
        
        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
