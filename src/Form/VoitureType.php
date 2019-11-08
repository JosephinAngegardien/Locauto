<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Voiture;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modele')
            ->add('marque')
            ->add('categories', EntityType::class, [
                "multiple" => true,
                "expanded" => true,
                'class' => Categorie::class,
            ])
            ->add('agence')
            ->add('reference')
            ->add('tarif')
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
