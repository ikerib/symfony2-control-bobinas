<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\AuxSerigrafia;
use Gitek\BackendBundle\Form\AuxSerigrafiaType;

/**
 * AuxSerigrafia controller.
 *
 */
class AuxSerigrafiaController extends Controller
{

    /**
     * Lists all AuxSerigrafia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->getUser();
        $entities = $em->getRepository('BackendBundle:AuxSerigrafia')->findAll();

        return $this->render('BackendBundle:AuxSerigrafia:index.html.twig', array(
            'entities' => $entities,
            'usuario'       => $usuario,
        ));
    }
    /**
     * Creates a new AuxSerigrafia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AuxSerigrafia();
        $usuario = $this->getUser();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxserigrafia_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:AuxSerigrafia:new.html.twig', array(
            'entity' => $entity,
            'usuario'       => $usuario,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AuxSerigrafia entity.
     *
     * @param AuxSerigrafia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AuxSerigrafia $entity)
    {
        $form = $this->createForm(new AuxSerigrafiaType(), $entity, array(
            'action' => $this->generateUrl('admin_auxserigrafia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AuxSerigrafia entity.
     *
     */
    public function newAction()
    {
        $entity = new AuxSerigrafia();
        $usuario = $this->getUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:AuxSerigrafia:new.html.twig', array(
            'entity' => $entity,
            'usuario'       => $usuario,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AuxSerigrafia entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxSerigrafia')->find($id);
        $usuario = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxSerigrafia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:AuxSerigrafia:show.html.twig', array(
            'entity'      => $entity,
            'usuario'       => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AuxSerigrafia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxSerigrafia')->find($id);
        $usuario = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxSerigrafia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:AuxSerigrafia:edit.html.twig', array(
            'entity'      => $entity,
            'usuario'       => $usuario,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AuxSerigrafia entity.
    *
    * @param AuxSerigrafia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AuxSerigrafia $entity)
    {
        $form = $this->createForm(new AuxSerigrafiaType(), $entity, array(
            'action' => $this->generateUrl('admin_auxserigrafia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AuxSerigrafia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxSerigrafia')->find($id);
        $usuario = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxSerigrafia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxserigrafia_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:AuxSerigrafia:edit.html.twig', array(
            'entity'      => $entity,
            'usuario'       => $usuario,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AuxSerigrafia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:AuxSerigrafia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AuxSerigrafia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_auxserigrafia'));
    }

    /**
     * Creates a form to delete a AuxSerigrafia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_auxserigrafia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
