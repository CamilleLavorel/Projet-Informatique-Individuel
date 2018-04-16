<?php

namespace ProjetInformatiqueIndividuel\Form\Type;


use ProjetInformatiqueIndividuel\Domain\Semestre;
use ProjetInformatiqueIndividuel\Domain\Universite;
use ProjetInformatiqueIndividuel\Domain\Logement;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SemestreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                    'label'=>'Titre du semestre')
            )
            ->add('duree', ChoiceType::class,array(
                'label'=>'Durée : ',
                'choices'  => array(
                    '1 semestre' => '1',
                    '2 semestres' => '2',
                    )
            ))
            ->add('annee', ChoiceType::class, array(
                'label'=> "Année d'école",
                'expanded'=> true,
                'multiple' => false,
                'choices'=>array(
                    '1A' => '1A',
                    '2A' => '2A',
                    '3A' => '3A'
                )
            ))
            ->add('datedebut',DateType::class,array(
                'label'=>'Date de début',
                'widget' => 'single_text',
                'format'=>'yyyy-MM-dd',
                'placeholder' => array(
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',)
            ))
            ->add('datefin',DateType::class,array(
                'label'=>'Date de fin',
                'widget' => 'single_text',
                'format'=>'yyyy-MM-dd',
                'placeholder' => array(
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',)
            ))
            ->add('description',TextareaType::class,array(
                'label'=>'Description'
            ))
            ->add('ressentisemestre',TextareaType::class,array(
                'label'=>"Votre ressenti sur votre expérience "
            ))
            ->add('ressentiuniversite',TextareaType::class,array(
                'label'=>"Votre ressenti sur l'université"
            ))
            ->add('photo',FileType::class,array(
                'required'=>false,
                'data_class'=>null
            ))

            ->add('universite', UniversiteType::class,array(
                'data_class'=>Universite::class
            ))
            ->add('logement', LogementType::class,array(
                'data_class'=>Logement::class
            ))
            ->add('cours', CollectionType::class,array(
                'entry_type'=>CoursType::class,
                'allow_add'=>true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Semestre::class,
        ));
    }
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Semestre::class
        ));
    }
}
