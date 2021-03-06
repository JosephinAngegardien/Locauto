<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('note', IntegerType::class, $this->getConfiguration("Note sur 5", "Veuillez donner une note de 0 à 5", [
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'class' => 'uk-input'
                ]
            ]))
            ->add('contenu', TextareaType::class, $this->getConfiguration("Donnez votre avis ", "Que pensez-vous de ce véhicule ?",[
                'attr' => ['class' => 'uk-input']
            ]))
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
