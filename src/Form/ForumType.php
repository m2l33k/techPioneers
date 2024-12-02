<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\User; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreForum')
            ->add('descriptionForum')
            ->add('createurForum', EntityType::class, [
                'class' => User::class, // Specify the User entity
                'choice_label' => 'nomUser', // Specify the field to display (assuming 'nom_user' is the user's name)
                'placeholder' => 'Select a user', // Optional: Add a placeholder for the select input
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
