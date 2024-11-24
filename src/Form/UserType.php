<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\RoleUserEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUser', TextType::class, [
                'label' => 'First Name',
                'required' => true,
            ])
            ->add('prenomUser', TextType::class, [
                'label' => 'Last Name',
                'required' => true,
            ])
            ->add('emailUser', EmailType::class, [
                'label' => 'Email',
                'required' => false, // Nullable in the entity
            ])
            ->add('motdepasseUser', PasswordType::class, [
                'label' => 'Password',
                'required' => true,
            ])
            ->add('numtelephoneUser', IntegerType::class, [
                'label' => 'Phone Number',
                'required' => true,
            ])
            ->add('datenaissanceUser', DateType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text', // HTML5 date picker
                'required' => true,
            ])
            ->add('photoUser', FileType::class, [
                'label' => 'Profile Picture',
                'required' => false, // Nullable in the entity
                'mapped' => false, // Set to false if the file is not directly mapped to the entity
            ])
            ->add('roleUser', ChoiceType::class, [
                'choices' => [
                    'Admin' => RoleUserEnum::ADMIN,
                    'Student' => RoleUserEnum::STUDENT,
                    'Teacher' => RoleUserEnum::TEACHER,
                ],
                'label' => 'Role',
                'expanded' => false, // Dropdown list
                'multiple' => false, // Single selection
                'data' => RoleUserEnum::STUDENT, // Default value
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

