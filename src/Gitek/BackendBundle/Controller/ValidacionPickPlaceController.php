<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\ValidacionPickPlace;
use Gitek\BackendBundle\Form\ValidacionPickPlaceType;

/**
 * ValidacionPickPlace controller.
 *
 */
class ValidacionPickPlaceController extends Controller
{

    /**
     * Lists all ValidacionPickPlace entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ValidacionPickPlace')->findAll();

        return $this->render('BackendBundle:ValidacionPickPlace:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ValidacionPickPlace entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ValidacionPickPlace();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_validacion_pickplace'));
        }

        return $this->render('BackendBundle:ValidacionPickPlace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ValidacionPickPlace entity.
     *
     * @param ValidacionPickPlace $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ValidacionPickPlace $entity)
    {
        $form = $this->createForm(new ValidacionPickPlaceType(), $entity, array(
            'action' => $this->generateUrl('admin_validacion_pickplace_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ValidacionPickPlace entity.
     *
     */
    public function newAction()
    {
        $entity = new ValidacionPickPlace();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:ValidacionPickPlace:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ValidacionPickPlace entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ValidacionPickPlace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValidacionPickPlace entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ValidacionPickPlace:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ValidacionPickPlace entity.
    *
    * @param ValidacionPickPlace $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ValidacionPickPlace $entity)
    {
        $form = $this->createForm(new ValidacionPickPlaceType(), $entity, array(
            'action' => $this->generateUrl('admin_validacion_pickplace_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ValidacionPickPlace entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ValidacionPickPlace')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValidacionPickPlace entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_validacion_pickplace'));
        }

        return $this->render('BackendBundle:ValidacionPickPlace:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ValidacionPickPlace entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:ValidacionPickPlace')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ValidacionPickPlace entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_validacion_pickplace'));
    }

    /**
     * Creates a form to delete a ValidacionPickPlace entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_validacion_pickplace_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
