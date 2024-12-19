<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('projetdesc')
            ->add('fichier', FileType::class, [
                'label' => 'Document ( PDF)',

                // unmapped means that this field is not associated with any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the file
                'required' => false,

                // constraints for the allowed file types
                'constraints' => [
                    new File([
                        'maxSize' => '2048k', // increase size limit if needed
                        'mimeTypes' => [
                            'application/pdf', // for .docx files
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier valide ( PDF)',
                    ])
                ]
            ])
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'EventName',
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
