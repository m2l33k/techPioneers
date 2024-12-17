<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('mailtrap@example.com')
            ->to('newuser@example.com') 
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('mailer/index.html.twig');

        $mailer->send($email);

        return new Response('Email was sent successfully.');
    }
}