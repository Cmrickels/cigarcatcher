<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Shape;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Shape controller.
 *
 * @Route("shape")
 */
class ShapeController extends Controller
{
    /**
     * Lists all shape entities.
     *
     * @Route("/", name="shape_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $shapes = $em->getRepository('AppBundle:Shape')->findAll();

        return $this->render('AppBundle:Shape:index.html.twig', array(
            'shapes' => $shapes,
        ));
    }

    /**
     * Creates a new shape entity.
     *
     * @Route("/new", name="shape_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $shape = new Shape();
        $form = $this->createForm('AppBundle\Form\ShapeType', $shape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $shape->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('shape_directory'),
                $fileName
            );

            $shape->setImage($fileName);

            $em->persist($shape);
            $em->flush($shape);

            return $this->redirectToRoute('shape_show', array('id' => $shape->getId()));
        }

        return $this->render('AppBundle:Shape:new.html.twig', array(
            'shape' => $shape,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a shape entity.
     *
     * @Route("/{id}", name="shape_show")
     * @Method("GET")
     */
    public function showAction(Shape $shape)
    {
        $deleteForm = $this->createDeleteForm($shape);

        return $this->render('AppBundle:Shape:show.html.twig', array(
            'shape' => $shape,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing shape entity.
     *
     * @Route("/{id}/edit", name="shape_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Shape $shape)
    {
        $deleteForm = $this->createDeleteForm($shape);
        $editForm = $this->createForm('AppBundle\Form\ShapeType', $shape);
        $shape_clone = clone $shape;
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $shape->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('shape_directory'),
                $fileName
            );

            $shape->setImage($fileName);

            $em->persist($shape);
            $em->flush($shape);
            unlink('uploads/shape/' . $shape->getImage());

            return $this->redirectToRoute('shape_edit', array('id' => $shape->getId()));
        }

        return $this->render('AppBundle:Shape:edit.html.twig', array(
            'shape' => $shape,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a shape entity.
     *
     * @Route("/{id}", name="shape_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Shape $shape)
    {
        $form = $this->createDeleteForm($shape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shape);
            $em->flush($shape);
        }

        return $this->redirectToRoute('shape_index');
    }

    /**
     * Creates a form to delete a shape entity.
     *
     * @param Shape $shape The shape entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Shape $shape)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shape_delete', array('id' => $shape->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param Size $size
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="manufacturer_index_delete")
     */
    public function deleteIndexAction(Shape $shape){
        $em = $this->getDoctrine()->getManager();
        $em->remove($shape);
        $em->flush();
        unlink('uploads/shape/' . $shape->getImage());
        return $this->redirectToRoute('shape_index');
    }
}
