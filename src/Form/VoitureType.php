<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Agence;
use App\Entity\Marque;
use App\Entity\Voiture;
use App\Form\ImageType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modele', TextType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Modèle'
            ])
            ->add('marque', EntityType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Marque',
                'class' => Marque::class
            ])
            ->add('categories', EntityType::class, [
                "multiple" => true,
                "expanded" => true,
                'class' => Categorie::class,
            ])
            ->add('agence', EntityType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Agence',
                'class' => Agence::class
            ])
            ->add('reference', TextType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Référence'
            ])
            ->add('tarif', IntegerType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Tarif journalier en euros'
            ])
            ->add('images', CollectionType::class,  [
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => "Choisir image :", ],
                'allow_add' => true,
                'allow_delete' => true,
                "by_reference" => false,
                'label' => false 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
