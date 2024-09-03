<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Form\ModulType;
use App\Repository\ModulRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModulController extends AbstractController
{
    #[Route('/modul', name: 'app_modul')]
    public function index(ModulRepository $modulRepository): Response
    {

        $modules = $modulRepository->findAll();

        return $this->render('modul/index.html.twig', [
            'modules' => $modules
        ]);
    }

    #[Route('/modul/new', name: 'modul.new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $modul = new Modul();
        $form = $this->createForm(ModulType::class, $modul);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $modul = $form->getData();


            $manager->persist($modul);
            $manager->flush();


            $this->addFlash('success','Votre module a été créé avec succès !' );
            
            return $this->redirectToRoute('app_modul');
        }

        return $this->render('modul/new.html.twig',[
           'form'=> $form->createView()
        ]);

    }

    #[Route('/modul/edit/{id}', name: 'edit.modul')]
    public function edit(Modul $modul,Request $request, EntityManagerInterface $manager ): Response
     {
        $form = $this->createForm(ModulType::class, $modul);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modul = $form->getData();

            $manager->persist($modul);
            $manager->flush();

            $this->addFlash('success','Votre module a été modifié avec succès !' );

            return $this->redirectToRoute('app_modul');
        }

        return $this->render('modul/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    #[Route('/modul/{id}', name: 'show.modul')]
    public function show(Modul $modul): Response
    {
        return $this->render('modul/show.html.twig', [
            'modul' =>  $modul
        ]);
    }



    #[Route('/modul/{id}/delete', name: 'delete.modul')]
    public function delete(Modul $modul, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($modul);
        $entityManager->flush();

        $this->addFlash('success', 'Le modul a bien été supprimée !');

        return $this->redirectToRoute(('app_modul'));
    }



}
