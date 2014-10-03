<?php
/**
 * User: Iker Ibarguren
 * Date: 03/10/14
 * Time: 09:56
 */
namespace Gitek\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AuxsiplaceAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('articulo')
            ->add('componente') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('assambleon') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('ipulse') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('siplace') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('articulo')
            ->add('componente')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('articulo')
            ->add('componente')
            ->add('assambleon')
            ->add('ipulse')
            ->add('siplace')
        ;
    }
}