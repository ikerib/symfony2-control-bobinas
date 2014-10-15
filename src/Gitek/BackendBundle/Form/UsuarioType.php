<?php

namespace Gitek\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('encargado', 'choice', array(
                'choices' => array(
                    0 => 'No',
                    1 => 'Si'
                ),
            'expanded' => true,
            'multiple' => false,
            ))
            ->add('admin', 'choice', array(
                'choices' => array(
                    0 => 'No',
                    1 => 'Si'
                ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('avatarImg', 'file', array(
                'label' => 'Avatar:',
                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gitek\BackendBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gitek_backendbundle_usuario';
    }
}
