<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre_Evenement')
            ->add('Date_Evenement')
            ->add('Description_Evenement')
            ->add('Organisateur_Evenement')
            ->add('Lien_Evenement')
            ->add('Lieu_Evenement')
            ->add('category', EntityType::class, [ // Add association to Category
                'class' => Category::class,
                'choice_label' => 'nomCategory', // Display the category name
                'placeholder' => 'Select a Category', // Optional: Placeholder text
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
