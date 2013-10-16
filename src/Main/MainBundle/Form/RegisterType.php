<?php
// src/Blogger/BlogBundle/Form/RegisterType.php

namespace Main\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname','text',array('required'=>false));
        $builder->add('lastname','text',array('required'=>false));
        $builder->add('email','text',array('required'=>false));
        $builder->add('mobile','text',array('required'=>false));
        $builder->add('gender','choice',array('required'=>false,'choices'=>array('1'=>'Male','0'=>'Female'),'data' =>'1','multiple'=>false,'expanded' => true,'empty_value' => false,));
        $builder->add('username','text',array('required'=>false));
        $builder->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Password and Confirm password must be the same.',
                    'required' => false,
                    'first_options'  => array('label' => 'Password'),
                    'first_name'=>'password',
                    'second_options' => array('label' => 'Confirm Password'),
                    'second_name'=>'confirmation'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Main\MainBundle\Entity\Users'
        ));
    }
    public function getName()
    {
        return 'register';
    }
}