<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();
        
        return $this->render('user/index.html.twig',[
            'users' =>  $users
        ]);
    }


    #[Route('/admin/user/{id}/delete', name: 'delete.user')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le formateur a bien été supprimée !');

        return $this->redirectToRoute(('app_user'));
    }








}
