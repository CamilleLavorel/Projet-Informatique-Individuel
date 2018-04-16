<?php

namespace ProjetInformatiqueIndividuel\Form\Type;

use ProjetInformatiqueIndividuel\Domain\Cours;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label_attr'=>array('class'=>'col-sm-5 control-label'),
                'attr'=>array(
                    'class'=>'form-control',
                    'rows'=>'1'
                )))
            ->add('description',TextAreaType::class, array(
                'label_attr'=>array('class'=>'col-sm-5 control-label'),
                'attr'=>array(
                    'class'=>'form-control',
                    'rows'=>'3'
                )))
            ->add('ressenti',TextAreaType::class, array(
                'label_attr'=>array('class'=>'col-sm-5 control-label'),
                'attr'=>array(
                    'class'=>'form-control',
                    'rows'=>'3'
                )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Cours::class,
        ));
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Cours::class
        ));
    }

}