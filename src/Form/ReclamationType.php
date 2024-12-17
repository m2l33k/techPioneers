<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ReclamationType extends AbstractType
{
  private MailerInterface $mailer;

  public function __construct(MailerInterface $mailer)
  {
      $this->mailer = $mailer;
  }
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {

        $builder
            ->add('title')
            ->add('description')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
        ;

      
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
