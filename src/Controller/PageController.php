<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig',);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('page/contact.html.twig',);
    }


    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig',);
    }


    #[Route('/team', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('page/team.html.twig',);
    }


    
    #[Route('/Testimonial', name: 'app_Testimonial')]
    public function Testimonial(): Response
    {
        return $this->render('page/Testimonial.html.twig',);
    }


    #[Route('/Courses', name: 'app_Courses')]
    public function Courses(): Response
    {
        return $this->render('page/Courses.html.twig',);
    }



}
