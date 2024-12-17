<?php
namespace App\Controller;

use App\Service\MailjetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(MailjetService $mailjetService): Response
    {
        $mailjetService->sendWelcomeEmail();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
