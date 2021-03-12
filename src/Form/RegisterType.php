<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' =>'Prénom',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'class'=>'bi bi-person-fill',
                    'placeholder' =>'Votre prénon',

                ]
            ])
            ->add('name', TextType::class, [
                'label' =>'Nom',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Votre nom'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' =>'Numero de téléphone',
                'required'=>true,
                'constraints'=>new Length([
                    'min'=>10,
                    'max'=>13
                ]),
                'attr'=>[
                    'placeholder' =>'Votre Numéro de téléphone',
                    'class'=>'bi bi-telephone-fill',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' =>'votre email',
                'required'=>false,
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>60
                ]),
                'attr'=>[
                    'placeholder' =>'Votre adresse email',
                    'class'=>'bi bi-envelope-fill',
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
                        'placeholder'=>'Merci de confirmer votre mot de passe',
                    ]

                ],
                'second_options'=>[
                    'label'=>'confirmer mot de passe',
                    'constraints'=>new Length([
                        'min'=>4,
                        'max'=>12
                    ]),
                    'attr'=> [
                        'placeholder'=>'Merci de confirmer votre mot de passe',
                    ]
                ]
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos contions d utilisation',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "s'inscrire",
                'attr'=> [
                        'placeholder'=>'Merci de confirmer votre mot de passe',
                        'class'=>'btn btn-primary btn-sm'
                ]
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
