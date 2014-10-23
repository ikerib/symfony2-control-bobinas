<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\Checksiplace;
use Gitek\BackendBundle\Form\ChecksiplaceType;

/**
 * Checksiplace controller.
 *
 */
class ChecksiplaceController extends Controller
{

    /**
     * Lists all Checksiplace entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Checksiplace')->findAll();

        return $this->render('BackendBundle:Checksiplace:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Checksiplace entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Checksiplace();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('checksiplace'));
        }

        return $this->render('BackendBundle:Checksiplace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Checksiplace entity.
     *
     * @param Checksiplace $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Checksiplace $entity)
    {
        $form = $this->createForm(new ChecksiplaceType(), $entity, array(
            'action' => $this->generateUrl('checksiplace_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Checksiplace entity.
     *
     */
    public function newAction()
    {
        $entity = new Checksiplace();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:Checksiplace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Checksiplace entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Checksiplace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checksiplace entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Checksiplace:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Checksiplace entity.
    *
    * @param Checksiplace $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Checksiplace $entity)
    {
        $form = $this->createForm(new ChecksiplaceType(), $entity, array(
            'action' => $this->generateUrl('checksiplace_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Checksiplace entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Checksiplace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checksiplace entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('checksiplace_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Checksiplace:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Checksiplace entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Checksiplace')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Checksiplace entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('checksiplace'));
    }

    /**
     * Creates a form to delete a Checksiplace entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('checksiplace_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
