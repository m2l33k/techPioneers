<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\MailjetService;

class RegistrationController extends AbstractController
{
    private $security;
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            if ($user->getRoles("ROLE_ADMIN")) {
              return $this->redirectToRoute('Dashboard.html.twig');
          } elseif ($user->getRoles("ROLE_TEACHER")) {
              return $this->redirectToRoute('Dashboard1.html.twig');
          } elseif ($user->getRoles("ROLE_STUDENT")) {
              return $this->redirectToRoute('STUDENT.html.twig');
          } else {
              // Default redirect or error handling
              return $this->redirectToRoute('Welcome');
          } // Redirect to a desired route
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
