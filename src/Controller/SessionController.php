<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\TraineeRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
            
        ]);
    }


    #[Route('/session/new/{trainingId}', name: 'session.new')]
    public function new(Request $request, EntityManagerInterface $manager,TrainingRepository $trainingRepository, $trainingId ): Response
    {

        $training = $trainingRepository->find($trainingId);

        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();

            $session->setTraining($training);


            $manager->persist($session);
            $manager->flush();


            $this->addFlash('success','Votre session a été créé avec succès !' );
            
            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig',[
           'form'=> $form->createView()
        ]);

    }

    #[Route('/session/{id}/delete', name: 'delete.session')]
    public function delete(Session $session, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($session);
        $entityManager->flush();

        $this->addFlash('success', 'La session a bien été supprimée !');

        return $this->redirectToRoute(('app_session'));
    }

    #[Route('/session/{id}', name: 'show.session')]
    public function show(Session $session, SessionRepository $sessionRepository, TrainingRepository $trainingRepository, TraineeRepository $traineeRepository): Response
    {

      
        $sessionId = $session->getId();

        
        $nonInscrits = $sessionRepository->findTraineeNotInSession($session->getId());

        $trainees= $trainingRepository->findAll();
        
        return $this->render('session/show.html.twig', [
            'session' =>  $session,
            'trainees' =>  $trainees,
            'nonInscrits' => $nonInscrits,

            
           
        ]);
    }










    







}
