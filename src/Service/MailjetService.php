<?php

namespace App\Service;

use Symfony\Component\Mime\Email; // Import the Email class
use Symfony\Component\Mailer\MailerInterface; // Import the MailerInterface

class MailjetService
{
    private string $apiKey;
    private string $apiSecret;
    private string $adminEmail;
    private MailerInterface $mailer;

    public function __construct(string $apiKey, string $apiSecret, string $adminEmail, MailerInterface $mailer)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function sendWelcomeEmail(): void
    {
        $bodyText = 'Welcome to our platform! We are excited to have you onboard.';
        $bodyHtml = '<p>Welcome to our platform!</p><p>We are excited to have you onboard.</p>';
        $context = 'Welcome!';
        if (empty($bodyText) && empty($bodyHtml)) {
            throw new \LogicException('Email body cannot be empty.');
        }

        $email = (new Email())
            ->from($this->adminEmail)
            ->to($this->adminEmail) 
            ->subject('Welcome!')
            
            ->text($bodyText)
            ->html($bodyHtml);

        $this->mailer->send($email);
    }
}
