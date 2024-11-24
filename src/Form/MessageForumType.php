<?php

namespace App\Form;

use App\Entity\MessageForum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Createur_MessageForum')
            ->add('Id_Forum')
            ->add('Conetenu_Id_MessageForum')
            ->add('DateCreation_Id_MessageForum', null, [
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageForum::class,
        ]);
    }
}
