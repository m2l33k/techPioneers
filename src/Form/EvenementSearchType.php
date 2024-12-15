<?php
namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre_Evenement', TextType::class, [
                'required' => false,
                'label' => 'Titre de l\'événement',
                'attr' => ['placeholder' => 'Rechercher par titre'],
            ])
            ->add('Date_Evenement', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Date de l\'événement',
            ])
           
            ->add('Organisateur_Evenement', TextType::class, [
                'required' => false,
                'label' => 'Organisateur',
                'attr' => ['placeholder' => 'Rechercher par organisateur'],
            ])
            
            ->add('Lieu_Evenement', TextType::class, [
                'required' => false,
                'label' => 'Lieu',
                'attr' => ['placeholder' => 'Rechercher par lieu'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nomCategory', // Utilisez le bon nom de propriété
                'required' => false,
                'label' => 'Catégorie',
                'placeholder' => 'Sélectionner une catégorie',
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Pas de validation stricte sur une entité
        ]);
    }
}
