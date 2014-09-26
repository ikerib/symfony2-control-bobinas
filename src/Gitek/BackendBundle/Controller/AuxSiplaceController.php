<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\AuxSiplace;
use Gitek\BackendBundle\Form\AuxSiplaceType;

/**
 * AuxSiplace controller.
 *
 */
class AuxSiplaceController extends Controller
{

    /**
     * Lists all AuxSiplace entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:AuxSiplace')->findAll();

        return $this->render('BackendBundle:AuxSiplace:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new AuxSiplace entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AuxSiplace();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxsiplace', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:AuxSiplace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AuxSiplace entity.
     *
     * @param AuxSiplace $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AuxSiplace $entity)
    {
        $form = $this->createForm(new AuxSiplaceType(), $entity, array(
            'action' => $this->generateUrl('admin_auxsiplace_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AuxSiplace entity.
     *
     */
    public function newAction()
    {
        $entity = new AuxSiplace();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:AuxSiplace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AuxSiplace entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxSiplace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxSiplace entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:AuxSiplace:edit.html.twig', array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AuxSiplace entity.
    *
    * @param AuxSiplace $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AuxSiplace $entity)
    {
        $form = $this->createForm(new AuxSiplaceType(), $entity, array(
            'action' => $this->generateUrl('admin_auxsiplace_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AuxSiplace entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxSiplace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxSiplace entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxsiplace', array('id' => $id)));
        }

        return $this->render('BackendBundle:AuxSiplace:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AuxSiplace entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:AuxSiplace')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AuxSiplace entity.');
            }

            $em->remove($entity);
            $em->flush();
//        }

        return $this->redirect($this->generateUrl('admin_auxsiplace'));
    }

    /**
     * Creates a form to delete a AuxSiplace entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_auxsiplace_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
