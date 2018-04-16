<?php

namespace ProjetInformatiqueIndividuel\Form\Type;


use ProjetInformatiqueIndividuel\Domain\Entreprise;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',IntegerType::class,array(
                'required'=>false
            ))
            ->add('nom', TextType::class)
            ->add('adresse',TextType::class)
            ->add('ville',TextType::class)
            ->add('pays',TextType::class)
            ->add('description',TextareaType::class)
            ->add('mail',EmailType::class)
            ->add('logo', FileType::class, array(
                'required'=>false,
                'label'=>'Logo (facultatif)',
                'data_class'=>null
            ))

        ;
    }
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Entreprise::class
        ));
    }
}
