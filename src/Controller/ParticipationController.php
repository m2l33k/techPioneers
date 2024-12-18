<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParticipationController extends AbstractController
{
  public function index(): Response
  {
      // Logic to fetch all participations
      return $this->render('participation/index.html.twig', [
          // Pass data to the template
      ]);
  }
}
