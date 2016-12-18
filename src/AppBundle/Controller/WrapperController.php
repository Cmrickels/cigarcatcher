<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wrapper;
use AppBundle\Form\WrapperType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * wrapper controller.
 *
 * @Route("wrapper")
 */
class WrapperController extends Controller
{
    /**
     * Lists all wrapper entities.
     *
     * @Route("/", name="wrapper_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wrappers = $em->getRepository(Wrapper::class)->findAll();

        return $this->render('AppBundle:wrapper:index.html.twig', array(
            'wrappers' => $wrappers,
        ));
    }

    /**
     * Creates a new wrapper entity.
     *
     * @Route("/new", name="wrapper_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $wrapper = new wrapper();
        $form = $this->createForm(WrapperType::class, $wrapper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wrapper);
            $em->flush($wrapper);

            return $this->redirectToRoute('wrapper_index', array('id' => $wrapper->getId()));
        }

        return $this->render('AppBundle:Wrapper:new.html.twig', array(
            'wrapper' => $wrapper,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a wrapper entity.
     *
     * @Route("/{id}", name="wrapper_show")
     * @Method("GET")
     */
    public function showAction(Wrapper $wrapper)
    {
        $deleteForm = $this->createDeleteForm($wrapper);

        return $this->render('AppBundle:Wrapper:show.html.twig', array(
            'wrapper' => $wrapper,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing wrapper entity.
     *
     * @Route("/{id}/edit", name="wrapper_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Wrapper $wrapper)
    {
        $deleteForm = $this->createDeleteForm($wrapper);
        $editForm = $this->createForm('AppBundle\Form\WrapperType', $wrapper);
        $manu_clone = clone $wrapper;

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wrapper);
            $em->flush($wrapper);
            return $this->redirectToRoute('wrapper_edit', array('id' => $wrapper->getId()));
        }

        return $this->render('AppBundle:Wrapper:edit.html.twig', array(
            'wrapper' => $wrapper,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wrapper entity.
     *
     * @Route("/{id}", name="wrapper_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Wrapper $wrapper)
    {
        $form = $this->createDeleteForm($wrapper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wrapper);
            $em->flush($wrapper);
        }

        return $this->redirectToRoute('wrapper_index');
    }

    /**
     * Creates a form to delete a wrapper entity.
     *
     * @param wrapper $wrapper The wrapper entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Wrapper $wrapper)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wrapper_delete', array('id' => $wrapper->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * @param wrapper $wrapper
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="wrapper_index_delete")
     */
    public function deleteIndexAction(Wrapper $wrapper){
        $em = $this->getDoctrine()->getManager();
        $em->remove($wrapper);
        $em->flush();
        return $this->redirectToRoute('wrapper_index');
    }
}
