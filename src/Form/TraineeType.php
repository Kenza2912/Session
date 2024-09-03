<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('firstName',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('gender')
            ->add('dateBirth',DateType::class, [
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('city',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('email')
            ->add('phone')

            // ->add('sessions', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}
