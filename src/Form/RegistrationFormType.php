<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUser', TextType::class, [
                'label' => 'First Name',
                'attr' => ['placeholder' => 'Enter your first name']
            ])
            ->add('prenomUser', TextType::class, [
                'label' => 'Last Name',
                'attr' => ['placeholder' => 'Enter your last name']
            ])
            ->add('emailUser', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Enter your email address']
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false, // Not mapped to the entity field
                'label' => 'Password',
                'attr' => ['placeholder' => 'Enter your password']
            ])
            ->add('numtelephoneUser', TelType::class, [
                'label' => 'Phone Number',
                'attr' => ['placeholder' => 'Enter your phone number']
            ])
            ->add('datenaissanceUser', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date of Birth',
                'attr' => ['placeholder' => 'Select your date of birth']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
