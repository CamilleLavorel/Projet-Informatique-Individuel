<?php

namespace ProjetInformatiqueIndividuel\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class,array(
                'label' =>'Prénom'
            ))
            ->add('nom', TextType::class)
            ->add('email', EmailType::class)
            ->add('username', TextType::class,array(
                'label'=>'Login'
            ))
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                'invalid_message' => 'Veuillez ressaisir le mot de passe. Les deux mots de passe saisis ne sont pas identiques.',
                'options'         => array('required' => true),
                'first_options'   => array('label' => 'Mot de passe'),
                'second_options'  => array('label' => 'Confirmer votre mot de passe'),
            ))
            ->add('description', TextareaType::class)
            ->add('promo', ChoiceType::class,array(
                'choices' => array(
                    '2006'=>2006,
                    '2007'=>2007,
                    '2008'=>2008,
                    '2009'=>2009,
                    '2010'=>2010,
                    '2011'=>2011,
                    '2012'=>2012,
                    '2013'=>2013,
                    '2014'=>2014,
                    '2015'=>2015,
                    '2016'=>2016,
                    '2017'=>2017,
                    '2018'=>2018,
                    '2019'=>2019,
                    '2020'=>2020,
                    '2021'=>2021,
                    '2022'=>2022
                )
            ))
            ->add('photo', FileType::class, array(
                'required'=> false,
                'label'=> 'Photo (facultatif)',
                'data_class'=>null

            ))
            ->add('role', ChoiceType::class, array(
                'required'=>false,
                'choices'=>array(
                    'Utilisateur'=>'ROLE_USER',
                    'Admin'=>'ROLE_ADMIN'
                )
            ))
        ;
    }

    public function getName()
    {
        return 'user';
    }
}

