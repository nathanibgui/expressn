<?php

namespace App\Form;

use App\Entity\Realisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RealisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('prix')
            ->add('date')
            ->add('id_client')
            ->add('id_technicien')
            ->add('save', SubmitType::class)
        ;

       // $builder->add('relation',EntityType::class, [

          //  'class'          => OtherEntity::class,
         //   'choice_label'   => 'name',
           // 'placeholder'    => 'Choice option',
           // 'required'       => true,


       // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisation::class,
        ]);
    }
}
