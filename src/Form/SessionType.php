<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'nameTraining',
                'attr'=>[
                    'class'=>'form-label mt-4'
                ]
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
