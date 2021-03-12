<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('addresses',EntityType::class,[
                'label'=>false,
                'required'=>true,
                'class'=>Address::class,
                'choices'=>$user->getAddresses(),
                'multiple'=>false,
                'expanded'=>true,
            ])

            ->add('carriers',EntityType::class,[
                'label'=>'choisiser votre addresse Transporteur',
                'required'=>true,
                'class'=>Carrier::class,
                //'choices'=>$user->getAdresses(),
                'multiple'=>false,
                'expanded'=>true,
            ])

            ->add('submit',SubmitType::class, [
                'label'=>'valider ma commande',
                'attr'=>[
                    'class'=>'btn btn-success m-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user'=>array(),
        ]);
    }
}
