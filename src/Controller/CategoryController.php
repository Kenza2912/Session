<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{


    #[Route('/', name: 'home')]
    public function home(): Response
    {
       
        return $this->render('home.html.twig');
    }
    
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();


        return $this->render('category/index.html.twig', [
            'categories' =>  $categories
        ]);
    }

    #[Route('/category/new', name: 'category.new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();


            $manager->persist($category);
            $manager->flush();


            $this->addFlash('success','Votre catégorie a été créé avec succès !' );
            
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/new.html.twig',[
           'form'=> $form->createView()
        ]);

    }

    #[Route('/category/{id}', name: 'show.category')]
    public function show(Category $category): Response
    {
       
            return $this->render('category/show.html.twig', [
                'category' =>  $category
            ]);
        
    }

    

    #[Route('/category/edit/{id}', name: 'edit.category')]
    public function edit(Category $category,Request $request,EntityManagerInterface $manager ): Response
     {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success','Votre catégory a été modifié avec succès !' );

            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }



    #[Route('/category/{id}/delete', name: 'delete.category')]
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a bien été supprimée !');

        return $this->redirectToRoute(('app_category'));
    }





}
