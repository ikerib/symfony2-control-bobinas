<?php

namespace Gitek\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogdetailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('componente')
            ->add('posicion1')
            ->add('posicion2')
            ->add('cantidad')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitek\FrontendBundle\Entity\Logdetail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gitek_frontendbundle_logdetail';
    }
}
