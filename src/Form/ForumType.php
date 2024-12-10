<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\User; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreForum', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-z0-9 ]+$/',
                        'message' => 'The forum title can only contain letters and numbers.',
                    ]),
                ],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('descriptionForum', TextareaType::class, [
                'label' => 'Forum Description',
                'attr' => ['class' => 'form-control form-control-lg', 'rows' => 4],
               
            ])
            ->add('createurForum', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nomUser', // Ensure 'nomUser' is a valid field in User entity
                'placeholder' => 'Select a user',
                'label' => 'Forum Creator',
                'attr' => ['class' => 'form-select form-select-lg'],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
