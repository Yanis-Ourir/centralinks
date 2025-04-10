<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Service\PostAggregator;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
final class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(CategoryRepository $categoryRepository, PostAggregator $postAggregator): Response
    {
        $user = $this->getUser();
        $categories = $categoryRepository->findBy(['owner' => $user]);
        $posts = $postAggregator->fetchAllPosts();
  

        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
