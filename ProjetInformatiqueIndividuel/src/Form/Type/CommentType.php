<?php

namespace ProjetInformatiqueIndividuel\Form\Type;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, array('required' => true)
        );
    }

    public function getName()
    {
        return 'comment';
    }
}

