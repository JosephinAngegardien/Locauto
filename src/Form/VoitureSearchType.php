<?php

namespace App\Form;

use App\Entity\VoitureSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VoitureSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxTarif', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Tarif maximum']
            ])
            // ->add('marque', [
            //     'required' => false,
            //     'label' => false,
            //     'attr' => ['placeholder' => 'Marque']
            // ])
            // ->add('categorie', [
            //     'required' => false,
            //     'label' => false,
            //     'attr' => ['placeholder' => 'Catégorie']
            // ])
            // ->add('agence', [
            //     'required' => false,
            //     'label' => false,
            //     'attr' => ['placeholder' => 'Agence']
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VoitureSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }
}
