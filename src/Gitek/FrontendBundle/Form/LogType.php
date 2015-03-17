<?php

namespace Gitek\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('of')
            ->add('operacion')
            ->add('validacion1')
            ->add('validacion2')
            ->add('validacion3')
            ->add('validacion4')
            ->add('validacion5')
            ->add('validacion6')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitek\FrontendBundle\Entity\Log'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gitek_frontendbundle_log';
    }
}
