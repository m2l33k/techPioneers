<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Evenement1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre_Evenement')
            ->add('Date_Evenement', null, [
                'widget' => 'single_text',
            ])
            ->add('Description_Evenement')
            ->add('Organisateur_Evenement')
            ->add('lien_Evenement')
            ->add('Lieu_Evenement')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nomCategory', // Use the correct property name
                'placeholder' => 'Select a Category',
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
