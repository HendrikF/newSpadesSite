<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array(
                'attr' => array('class' => 'btn btn-success'),
                'label' => 'Save Tag'))
            ->add('delete', 'submit', array(
                'attr' => array('class' => 'btn btn-danger pull-right btn-xs'),
                'label' => 'Delete Tag'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tag',
        ));
    }

    public function getName()
    {
        return 'tag';
    }
}
