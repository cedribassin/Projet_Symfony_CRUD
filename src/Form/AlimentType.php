<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Aliment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AlimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('imageFile', FileType::class, ['required'=>false])
            ->add('calorie')
            ->add('proteine')
            ->add('glucide')
            ->add('lipide')
            ->add('type', EntityType::class,[
                'class' => Type::class, //=> permet d'avoir une liste déroulante sur cette entité
                'choice_label' => 'libelle' //=> on indique sur quel champs
                ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aliment::class,
        ]);
    }
}
