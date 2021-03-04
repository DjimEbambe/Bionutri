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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TelType::class, [
                'disabled' => true,
                'label'=> 'Mon télephone'

            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label'=> 'Mon adresse email'
            ] )

            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label'=> 'Mon prénom'
            ] )
            ->add('name', TextType::class, [
                'disabled' => true,
                'label'=> 'Nom'
            ] )

            ->add('old_password', PasswordType::class, [
                'label'=> 'Mot de passe actuel',
                'mapped' => false,
                'attr' =>[
                    'placeholder'=>'veillez saisir votre mot de passe actuels'
                ]
            ] )

            ->add('new_password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'mapped' => false,
                'invalid_message'=>'le mot de passe et la confirmation doivent etre identique',
                'label'=>'Nouveau mot de passe',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Nouveau Mot de passe',
                    'attr'=> [
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]
                ],
                'second_options'=>[
                    'label'=>'Confirmer votre nouveau mot de passe',
                    'attr'=> [
                        'placeholder'=>'Merci de confirmer votre nouveau mot de passe'
                    ]
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "mettre à jour"
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
