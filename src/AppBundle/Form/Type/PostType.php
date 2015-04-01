<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', 'text', array(
                'attr' => array('class' => 'form-control')))
            ->add('title', 'text', array(
                'attr' => array('class' => 'form-control')))
            ->add('published', 'date', array(
                'attr' => array('class' => 'form-control')))
            ->add('content', 'textarea', array(
                'attr' => array('class' => 'form-control', 'rows' => 25)))
            ->add('tags', 'tags', array(
                'attr' => array('class' => 'form-control tags-input'),
                'required' => false))
            ->add('save', 'submit', array(
                'attr' => array('class' => 'btn btn-success'),
                'label' => 'Save Post'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
        ));
    }

    public function getName()
    {
        return 'post';
    }
}
