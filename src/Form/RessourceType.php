<?php
// src/Form/RessourceType.php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Ressource;
use App\Enum\TypeRessourceEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('Titre_Ressource')
        ->add('Description_Ressource')
        ->add('Type_Ressource', ChoiceType::class, [
            'choices' => [
                'Video' => TypeRessourceEnum::VIDEO, // Replace with your actual enum cases
                'Document' => TypeRessourceEnum::DOCUMENT,
                //'Quiz' => TypeRessourceEnum::QUIZ,
            ],
            'choice_label' => function (?TypeRessourceEnum $choice) {
                return $choice ? $choice->name : ''; // Label is the enum case name
            },
            'choice_value' => function (?TypeRessourceEnum $choice) {
                return $choice ? $choice->value : ''; // Value is the enum case value
            },
            'placeholder' => 'Select a type',
            'required' => true,
        ])
        ->add('Id_Cours', EntityType::class, [
            'class' => Cours::class,
            'choice_label' => 'Titre_Cours', // Assuming this is the property to display
            'placeholder' => 'Select a course',
            'required' => true,
        ])
        ->add('Url_Ressource')
        ->add('DateCreation_Ressource')
        ->add('Id_Enseignat_Ressource', null, [
            'label' => 'Teacher ID',
            'required' => true,
        ]);
}
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
?>