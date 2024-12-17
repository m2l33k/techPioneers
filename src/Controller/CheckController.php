<?php

namespace App\Controller;
use App\Controller\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CheckController extends AbstractController
{
    #[Route('/check', name: 'app_check')]    
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Security $security): Response
    {
        // Get the logged-in user
        $user = $security->getUser();

        return $this->render('page/STUDENT.html.twig', [
            'user' => $user,
        ]);
    }
}
