<?php

namespace App\Form;

use App\Entity\Agence;
use App\Entity\Marque;
use App\Entity\Categorie;
use App\Entity\VoitureSearch;
use App\Repository\AgenceRepository;
use App\Repository\MarqueRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'attr' => ['class' => 'uk-input']
            ])
            ->add('minTarif', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['class' => 'uk-input']
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'required' => false,
                'query_builder' => function (MarqueRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'required' => false,
                'query_builder' => function (CategorieRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('agence', EntityType::class, [
                'class' => Agence::class,
                'required' => false,
                'query_builder' => function (AgenceRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.ville', 'ASC');
                },
                'choice_label' => 'ville',
                'attr' => ['class' => 'uk-input']
            ])
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
