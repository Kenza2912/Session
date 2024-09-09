<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Form\ProgramType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('nbPlaces', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 50,
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(50)
                ]
            ])
            // ->add('training', EntityType::class, [
            //     'class' => Training::class,
            //     'choice_label' => 'nameTraining',
            //     'attr'=>[
            //         'class'=>'form-label mt-4'
            //     ]
            // ])
            ->add('programs', CollectionType::class, [
                    'entry_type'=>ProgramType::class,
                    'allow_add' => true,
                    'allow_delete'=> true,
                    'prototype' => true, // on autorise l'ajout de nouveau élément dans session qui seront persister grace au casscade persist sur l'élement programme et ca va activer un data prototype qui sera un attribut html qu'on pourra manipuler en js
                    
                    'by_reference'=> false, // c'est Program qui est propriétaire de la relation (on évite un mapping false)
                    ])
            // ->add('trainees', EntityType::class, [
            //     'class' => Trainee::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            //     'attr'=>[
            //         'class'=>'form-label mt-4'
            //     ]
            // ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer une session'
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
