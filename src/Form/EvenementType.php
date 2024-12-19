<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Enum\TypeEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('EventName')
            ->add('EventDate', null, [
                'widget' => 'single_text',
                'required' => false, // Allows the field to be optional
                'empty_data' => null, // Ensures empty fields are treated as null
            ])
            ->add('EventPlace')
            ->add('EventDesc')
            ->add('TypeEvenement', ChoiceType::class,[
                'choices' => [
                    'Hackathon' => 'Hackathon',
                    'Seminaire' => 'seminaire',
                    'conference' => 'conference',
                    'Meetup' => 'Meetup',
                    'Zoom' => 'Zoom',
                    'Webinar' => 'Webinar', 
                    'Workshop' => 'Workshop',
                    'Autre' => 'Autre',                 
                ],
                'placeholder' => 'Sélectionnez un type',
            ])

            ->add('capacite')
            ->add('image',FileType::class, [
                'label' => 'picture for your  profile (image file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,


                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ]])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
    /**
     * Maps TypeEvent enum values to display-friendly choices.
     *
     * @return array<string, TypeEvent>
     */

}
