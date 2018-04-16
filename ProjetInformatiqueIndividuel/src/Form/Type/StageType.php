<?php

namespace ProjetInformatiqueIndividuel\Form\Type;


use ProjetInformatiqueIndividuel\Domain\Stage;
use ProjetInformatiqueIndividuel\Domain\Entreprise;
use ProjetInformatiqueIndividuel\Domain\Logement;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label'=>'Titre du stage')
        )
            ->add('duree', TextType::class,array(
                'label'=>'Durée du stage'
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
            ->add('sujet', TextType::class, array(
                'label'=>'Sujet'
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
            ->add('ressentistage',TextareaType::class,array(
                'label'=>'Votre ressenti sur le stage'
            ))
            ->add('ressentientreprise',TextareaType::class,array(
                'label'=>"Votre ressenti sur l'entreprise"
            ))
            ->add('entreprise', EntrepriseType::class,array(
                'data_class'=>Entreprise::class
            ))
            ->add('logement', LogementType::class,array(
                'data_class'=>Logement::class
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Stage::class
        ));
    }
}
