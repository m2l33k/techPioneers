<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordRequestFormType;
use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\ResetPassword\TokenGeneratorInterface;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    private ResetPasswordHelperInterface $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    #[Route('', name: 'app_forgot_password_request', methods: ['GET', 'POST'])]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if ($user instanceof User) {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);

                $email = (new Email())
                    ->from('no-reply@example.com')
                    ->to($user->getEmail())
                    ->subject('Password Reset Request')
                    ->html($this->renderView('reset_password/email.html.twig', [
                        'resetToken' => $resetToken,
                    ]));

                $mailer->send($email);
            }

            return $this->redirectToRoute('app_check_email');
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/check-email', name: 'app_check_email', methods: ['GET'])]
    public function checkEmail(): Response
    {
        return $this->render('reset_password/check_email.html.twig');
    }

    #[Route('/reset/{token}', name: 'app_reset_password', methods: ['GET', 'POST'])]
    public function reset(Request $request, string $token = null): Response
    {
        if ($token) {
            try {
                $this->resetPasswordHelper->validateTokenAndFetchUser($token);
            } catch (ResetPasswordExceptionInterface $e) {
                $this->addFlash('reset_password_error', sprintf(
                    'There was a problem validating your reset request - %s',
                    $e->getReason()
                ));

                return $this->redirectToRoute('app_forgot_password_request');
            }

            $form = $this->createForm(ChangePasswordFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->getUser();
                $user->setPassword(
                    password_hash($form->get('plainPassword')->getData(), PASSWORD_BCRYPT)
                );

                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Your password has been reset.');

                return $this->redirectToRoute('app_login');
            }

            return $this->render('reset_password/reset.html.twig', [
                'resetForm' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('app_forgot_password_request');
    }
}
?>
