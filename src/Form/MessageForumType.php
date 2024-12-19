<?php

namespace App\Form;
use App\Entity\Forum;
use App\Entity\MessageForum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; // If you're using a textarea
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;  // If you're using a select/choice field

use App\Entity\User;


class MessageForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
   // In MessageForumType.php
   $builder
   ->add('ConetenuIdMessageForum', TextareaType::class, [
       'label' => 'Type Your Message',
       'required' => true,
       'attr' => [
                'class' => 'custom-input', // Add a custom class for styling
                'rows' => 5, // Adjust textarea size if necessary
            ],
            'row_attr' => [
                'class' => 'form-group', // Add a wrapper class
            ],
        ]);  
 

        
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MessageForum::class,
        ]);
    }
}