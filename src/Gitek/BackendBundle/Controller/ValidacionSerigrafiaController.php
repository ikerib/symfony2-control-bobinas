<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\ValidacionSerigrafia;
use Gitek\BackendBundle\Form\ValidacionSerigrafiaType;

/**
 * ValidacionSerigrafia controller.
 *
 */
class ValidacionSerigrafiaController extends Controller
{

    /**
     * Lists all ValidacionSerigrafia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:ValidacionSerigrafia')->findAll();

        return $this->render('BackendBundle:ValidacionSerigrafia:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ValidacionSerigrafia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ValidacionSerigrafia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_validacion_serigrafia'));
        }

        return $this->render('BackendBundle:ValidacionSerigrafia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ValidacionSerigrafia entity.
     *
     * @param ValidacionSerigrafia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ValidacionSerigrafia $entity)
    {
        $form = $this->createForm(new ValidacionSerigrafiaType(), $entity, array(
            'action' => $this->generateUrl('admin_validacion_serigrafia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ValidacionSerigrafia entity.
     *
     */
    public function newAction()
    {
        $entity = new ValidacionSerigrafia();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:ValidacionSerigrafia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing ValidacionSerigrafia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ValidacionSerigrafia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValidacionSerigrafia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:ValidacionSerigrafia:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ValidacionSerigrafia entity.
    *
    * @param ValidacionSerigrafia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ValidacionSerigrafia $entity)
    {
        $form = $this->createForm(new ValidacionSerigrafiaType(), $entity, array(
            'action' => $this->generateUrl('admin_validacion_serigrafia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ValidacionSerigrafia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:ValidacionSerigrafia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ValidacionSerigrafia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_validacion_serigrafia'));
        }

        return $this->render('BackendBundle:ValidacionSerigrafia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ValidacionSerigrafia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:ValidacionSerigrafia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ValidacionSerigrafia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_validacion_serigrafia'));
    }

    /**
     * Creates a form to delete a ValidacionSerigrafia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_validacion_serigrafia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
