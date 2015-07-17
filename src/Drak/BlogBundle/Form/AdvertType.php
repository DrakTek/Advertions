<?php

namespace Drak\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
            ->add('categories', 'entity', array(
                    'class'     => 'DrakBlogBundle:Category',
                    'property'  =>  'name',
                    'multiple'  =>  true,
                    'expanded'  =>  false,
            ))
            // ->add('updatedAt')
            ->add('sauver',     'submit')
            // ->add('nbApplications')
            // ->add('categories')
            // ->add('image')
        ;

        // on ajoute la fonction qui va écouter un évènement
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, // 1er argument : l'évènement qui nous interesse ici
            function(FormEvent $event){ // fonction à exécuter lorsque l'évènement est décléenché
                // on récupère notre objet advert sous-jacent
                $advert = $event->getData();

                // cette condition est importante
                if(null === $advert){
                    return; // on sors de la fonction sans rien faire 
                }

                if(!$advert->getPublished() || null === $advert->getId()) {
                    // si l'annonce n'est pas publiée ou si elle n'existe pas encore en base 
                    // alors on ajoute le champ published
                    $event->getForm()->add('published', 'checkbox', array('required'=>false ));
                } else {
                    // sinon on le supprime
                    $event->getForm()->remove('published');
                }

            }
        );
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
