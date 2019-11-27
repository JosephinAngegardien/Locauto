<?php

namespace App\Form;

use App\Entity\Location;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LocationType extends ApplicationType
{
    private $transformer;

    public function __construct(FrenchToDateTimeTransformer $transformer){
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut', DateType::class, $this->getConfiguration("Début de la location :", "..."), ['attr' => [ 'class' => 'uk-input']])
            ->add('fin', DateType::class, $this->getConfiguration("Fin de la location :", "..."), ['attr' => [ 'class' => 'uk-input']])
            // ->add('commentaire', TextareaType::class, $this->getConfiguration(false, "Vous pouvez donner
            //  votre avis sur les services de Locauto", ["required" => false]))
        ;
        // $builder->get('debut')->addModelTransformer($this->transformer);
        // $builder->get('fin')->addModelTransformer($this->transformer);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'validation_groups' => [
                'Default',
                'front'
            ]
        ]);
    }
}


