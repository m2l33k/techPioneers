<?php

namespace App\Form;
use App\Entity\Forum;
use App\Entity\MessageForum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;


class MessageForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('createurMessageForum', EntityType::class, [
            'class' => User::class, // Specify the User entity
            'choice_label' => 'nomUser', // Specify the field to display (assuming 'nom_user' is the user's name)
            'placeholder' => 'Select a user',
            'label' => 'User Name'  
        ])
        ->add('ConetenuIdMessageForum', null, [
            'label' => 'Message Content'  // Custom label for the content field
        ])
            ->add('forum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'titre_forum',  // Assuming `name` is a property in the `Forum` entity
                'placeholder' => 'Choose a forum',
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
