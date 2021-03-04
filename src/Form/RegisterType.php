<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' =>'Votre Prénom',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'merci de saisir votre Prénon'
                ]
            ])
            ->add('name', TextType::class, [
                'label' =>'Votre Nom',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre Mom'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' =>'Votre Numero de téléphone',
                'required'=>true,
                'constraints'=>new Length([
                    'min'=>10,
                    'max'=>13
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre Numero de téléphone'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' =>'votre email',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>60
                ]),
                'attr'=>[
                    'placeholder' =>'merci de saisir votre adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message'=>'le mot de passe et la confirmation doivent etre identique',
                'label'=>'votre mot de passe',
                'constraints'=>new Length([
                    'min'=>4,
                    'max'=>12
                ]),
                'required'=>true,
                'first_options'=>[
                    'label'=>'Mot de passe',
                    'attr'=> [
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]
                ],
                'second_options'=>[
                    'label'=>'confirmer mot de passe',
                    'attr'=> [
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "s'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
