<?php

namespace Gitek\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuxSiplaceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articulo')
            ->add('componente')
            ->add('assambleon')
            ->add('ipulse')
            ->add('siplace')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitek\BackendBundle\Entity\AuxSiplace'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gitek_backendbundle_auxsiplace';
    }
}
