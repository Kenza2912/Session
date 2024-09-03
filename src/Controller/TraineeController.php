<?php

namespace App\Controller;

use App\Form\TraineeType;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraineeController extends AbstractController
{
    #[Route('/trainee', name: 'app_trainee')]
    public function index(TraineeRepository $traineeRepository): Response
    {

        $trainees = $traineeRepository->findAll();
        return $this->render('trainee/index.html.twig', [
           'trainees' =>  $trainees
        ]);
    }



    #[Route('/trainee/new', name: 'trainee.new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $trainee = new Trainee();
        $form = $this->createForm(TraineeType::class, $trainee);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trainee = $form->getData();


            $manager->persist($trainee);
            $manager->flush();


            $this->addFlash('success','Votre stagiaire a été créé avec succès !' );
            
            return $this->redirectToRoute('app_trainee');
        }

        return $this->render('trainee/new.html.twig',[
           'form'=> $form->createView()
        ]);

    }






}
