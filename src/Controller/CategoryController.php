<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categortRepository): Response
    {

        $categories = $categoryRepository->findAll();


        return $this->render('category/index.html.twig', [
            'categories' =>  $categories
        ]);
    }


}
