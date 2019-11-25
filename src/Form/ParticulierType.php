<?php

namespace App\Form;

use App\Entity\Particulier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ParticulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [ 'class' => 'uk-input'],
                'label' => 'Courriel'
            ])
            ->add("username", TextType::class, [
                'attr' => [ 'class' => 'uk-input'],
                'label' => 'Pseudonyme'
            ])
            ->add("prenom", TextType::class, [
                'attr' => [ 'class' => 'uk-input'],
                'label' => 'Prénom'
            ])
            ->add("nom", TextType::class,  [
                'attr' => [ 'class' => 'uk-input'],
                'label' => 'Nom'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Il faut écrire deux fois le même mot de passe.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['attr' => [ 'class' => 'uk-input'], 'label' => 'Mot de passe'],
                'second_options' => ['attr' => [ 'class' => 'uk-input'], 'label' => 'Ecrivez à nouveau le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Particulier::class,
        ]);
    }
}
