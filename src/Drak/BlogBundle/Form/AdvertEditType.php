<?php

namespace Drak\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('slug')
            ->remove('mdate',      'date')
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'drak_blogbundle_advertedit';
    }

    public function getParent()
    {
        return new AdvertType();
    }
}
