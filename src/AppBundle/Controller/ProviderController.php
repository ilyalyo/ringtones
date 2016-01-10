<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ringtone;
use AppBundle\Form\RingtoneType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Provider controller.
 *
 * @Route("/provider")
 */
class ProviderController extends Controller
{
    /**
     * Lists all Ringtone entities.
     *
     * @Route("/", name="provider")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entities = $em->getRepository('AppBundle:Ringtone')->findBy(["user" => $user->getId()]);

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ringtone entity.
     *
     * @Route("/create", name="provider_ringtone_create")
     * @Method("POST")
     * @Template("AppBundle:Provider:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ringtone();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();
            $this->addFlash('success', 'blog.article.flash.create.success');

            return $this->redirect($this->generateUrl('provider'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Ringtone entity.
     *
     * @param Ringtone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ringtone $entity)
    {
        $form = $this->createForm(new RingtoneType(), $entity, array(
            'action' => $this->generateUrl('provider_ringtone_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Ringtone entity.
     *
     * @Route("/new", name="provider_ringtone_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ringtone();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ringtone entity.
     *
     * @Route("/{id}/edit", name="provider_ringtone_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ringtone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ringtone entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Ringtone entity.
     *
     * @param Ringtone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ringtone $entity)
    {
        $form = $this->createForm(new RingtoneType(), $entity, array(
            'action' => $this->generateUrl('provider_ringtone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Ringtone entity.
     *
     * @Route("/{id}", name="provider_ringtone_update")
     * @Method("PUT")
     * @Template("AppBundle:Provider:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ringtone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ringtone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'blog.article.flash.edit.success');

            return $this->redirect($this->generateUrl('provider'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ringtone entity.
     *
     * @Route("/{id}", name="provider_ringtone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Ringtone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ringtone entity.');
            }

            $this->addFlash('success', 'blog.article.flash.delete.success');
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('provider'));
    }

    /**
     * Creates a form to delete a Ringtone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provider_ringtone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
            ;
    }
}
