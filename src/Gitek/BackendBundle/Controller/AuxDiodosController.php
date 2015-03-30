<?php

namespace Gitek\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gitek\BackendBundle\Entity\AuxDiodos;
use Gitek\BackendBundle\Form\AuxDiodosType;

/**
 * AuxDiodos controller.
 *
 */
class AuxDiodosController extends Controller
{

    /**
     * Lists all AuxDiodos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:AuxDiodos')->findAll();
        $usuario = $this->getUser();

        return $this->render('BackendBundle:AuxDiodos:index.html.twig', array(
            'entities' => $entities,
            'usuario'       => $usuario,
        ));
    }
    /**
     * Creates a new AuxDiodos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AuxDiodos();
        $usuario = $this->getUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxdiodos', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:AuxDiodos:new.html.twig', array(
            'entity' => $entity,
            'usuario'       => $usuario,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AuxDiodos entity.
     *
     * @param AuxDiodos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AuxDiodos $entity)
    {
        $form = $this->createForm(new AuxDiodosType(), $entity, array(
            'action' => $this->generateUrl('admin_auxdiodos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AuxDiodos entity.
     *
     */
    public function newAction()
    {
        $entity = new AuxDiodos();
        $usuario = $this->getUser();
        $form   = $this->createCreateForm($entity);

        return $this->render('BackendBundle:AuxDiodos:new.html.twig', array(
            'entity' => $entity,
            'usuario'       => $usuario,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AuxDiodos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxDiodos')->find($id);
        $usuario = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxDiodos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:AuxDiodos:edit.html.twig', array(
            'entity'      => $entity,
            'usuario'       => $usuario,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AuxDiodos entity.
    *
    * @param AuxDiodos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AuxDiodos $entity)
    {
        $form = $this->createForm(new AuxDiodosType(), $entity, array(
            'action' => $this->generateUrl('admin_auxdiodos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AuxDiodos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:AuxDiodos')->find($id);
        $usuario = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AuxDiodos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_auxdiodos', array('id' => $id)));
        }

        return $this->render('BackendBundle:AuxDiodos:edit.html.twig', array(
            'entity'      => $entity,
            'usuario'       => $usuario,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AuxDiodos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:AuxDiodos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AuxDiodos entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('admin_auxdiodos'));
    }

    /**
     * Creates a form to delete a AuxDiodos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_auxdiodos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
