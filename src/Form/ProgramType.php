<?php

namespace App\Form;

use App\Entity\Modul;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('session', HiddenType::class)
            // ->add('session', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => 'id',
            // ])
            ->add('modul', EntityType::class, [
                'class' => Modul::class,
                'choice_label' => 'nameModul',
            ])
            ->add('duration', IntegerType::class, [
                'label'=> 'Durée en jours',
                'attr' => ['min'=> 1, 'max' =>100 ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
