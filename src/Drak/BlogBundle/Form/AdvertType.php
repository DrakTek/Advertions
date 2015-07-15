<?php

namespace Drak\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('slug')
            ->add('mdate',      'date')
            ->add('title',      'text')
            ->add('author',     'text')
            ->add('content',    'textarea')
            ->add('published',  'checkbox', array(
                                'required' =>  false))
            ->add('image',      new ImageType())
            ->add('categories', 'collection', array(
                                'type'          =>  new CategoryType(),
                                'allow_add'     =>  true,
                                'allow_delete'  =>  true))
            // ->add('updatedAt')
            ->add('sauver',     'submit')
            // ->add('nbApplications')
            // ->add('categories')
            // ->add('image')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Drak\BlogBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'drak_blogbundle_advert';
    }
}
