<?php

namespace Gitek\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ValidacionSerigrafiaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pregunta')
            ->add('mostrar')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitek\BackendBundle\Entity\ValidacionSerigrafia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gitek_backendbundle_validacionserigrafia';
    }
}
