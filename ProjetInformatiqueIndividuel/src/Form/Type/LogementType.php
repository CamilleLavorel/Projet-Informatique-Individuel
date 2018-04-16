<?php

namespace ProjetInformatiqueIndividuel\Form\Type;

use ProjetInformatiqueIndividuel\Domain\Logement;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextType::class, array(
                    'label'=>'Adresse du logement')
            )
            ->add('ville', TextType::class,array(
                'label'=>'Ville'
            ))
            ->add('pays', TextType::class, array(
                'label'=>'Pays'
            ))
            ->add('contact', TextType::class, array(
                'label'=>'Contact'
            ))
            ->add('description',TextareaType::class,array(
                'label'=>'Description du logement'
            ))
            ->add('ressenti',TextareaType::class,array(
                'label'=>'Votre ressenti sur le logement'
            ))
            ->add('budget',TextType::class,array(
                'label'=>"Votre budget mensuel (approximatif)"
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Logement::class
        ));
    }
}
