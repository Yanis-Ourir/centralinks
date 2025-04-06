<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

final class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
            'categories' => $categories,
        ]);
    }
}
