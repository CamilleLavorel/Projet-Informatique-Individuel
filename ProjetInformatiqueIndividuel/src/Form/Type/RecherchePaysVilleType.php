<?php

namespace ProjetInformatiqueIndividuel\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecherchePaysVilleType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder
->add('adresse', TextType::class, array(
    "required" =>false
))
->add('pays', TextType::class)
->add('ville',TextType:: class,array(
    'required'=>false
));
}
}