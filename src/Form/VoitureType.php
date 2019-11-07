<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            // ->add('images', EntityType::class, [
            //     "multiple" => true,
            //     'class' => Image::class,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
