<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrainingController extends AbstractController
{
    #[Route('/training', name: 'app_training')]
    public function index(TrainingRepository $trainingRepository): Response
    {

        $trainings = $trainingRepository->findAll();

        return $this->render('training/index.html.twig', [
            'trainings' =>  $trainings
        ]);
    }

    #[Route('/training/new', name: 'training.new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $training = new Training();
        $form = $this->createForm(TrainingType::class, $training);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $training = $form->getData();


            $manager->persist($training);
            $manager->flush();


            $this->addFlash('success','Votre formation a été créé avec succès !' );
            
            return $this->redirectToRoute('app_training');
        }

        return $this->render('training/new.html.twig',[
           'form'=> $form->createView()
        ]);

    }


    #[Route('/training/edit/{id}', name: 'edit.training')]
    public function edit(Training $training, Request $request,EntityManagerInterface $manager ): Response
     {
        $form = $this->createForm(TrainingType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $training = $form->getData();

            $manager->persist($training);
            $manager->flush();

            $this->addFlash('success','Votre formation a été modifié avec succès !' );

            return $this->redirectToRoute('app_training');
        }

        return $this->render('training/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }



    #[Route('/training/{id}/delete', name: 'delete.training')]
    public function delete(Training $training, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($training);
        $entityManager->flush();

        $this->addFlash('success', 'La formation a bien été supprimée !');

        return $this->redirectToRoute(('app_training'));
    }

}
