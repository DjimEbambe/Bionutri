<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' =>[
                    'placeholder'=>'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label'=>'votre prénom',
                'attr' =>[
                    'placeholder'=>'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label'=>'Votre nom',
                'attr' =>[
                    'placeholder'=>'Entrez votre nom'
                ]
            ])
            ->add('commune', TextType::class, [
                'label'=>'Votre commune',
                'attr' =>[
                    'placeholder'=>'Entre le nom de votre société'
                ]
            ])
            ->add('city', TextType::class, [
                'label'=>'Votre ville',
                'attr' =>[
                    'placeholder'=>'Entre le nom de votre société'
                ]
            ])
            ->add('address', TextType::class, [
                'label'=>'Votre Adresse',
                'attr' =>[
                    'placeholder'=>'6, buburu Q.MATONGE/C.KALAMU'
                ]
            ])
            ->add('reference', TextType::class, [
                'label'=>'Votre reference',
                'attr' =>[
                    'placeholder'=>'Entre le nom de votre reference'
                ]
            ])
            ->add('phone', TelType::class, [
                'label'=>'Téléphone',
                'attr' =>[
                    'placeholder'=>'Votre tétéphone'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'valider',
                'attr'=>[
                    'class'=>'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
