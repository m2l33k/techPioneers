<?php

namespace App\Form;

use App\Entity\Chatbot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChatbotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Datecreation_Chatbot', null, [
                'widget' => 'single_text'
            ])
            ->add('Contenu_Chatbot')
            ->add('Autheur_Chatbot')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chatbot::class,
        ]);
    }
}
