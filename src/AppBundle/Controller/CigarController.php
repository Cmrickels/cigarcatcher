<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cigar;
use AppBundle\Form\CigarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cigar controller.
 *
 * @Route("cigar")
 */
class CigarController extends Controller
{
    /**
     * Lists all cigar entities.
     *
     * @Route("/", name="cigar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cigars = $em->getRepository(Cigar::class)->findAll();

        return $this->render('AppBundle:Cigar:index.html.twig', array(
            'cigars' => $cigars,
        ));
    }

    /**
     * Creates a new cigar entity.
     *
     * @Route("/new", name="cigar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cigar = new Cigar();
        $form = $this->createForm(CigarType::class, $cigar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $cigar->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('cigar_directory'),
                $fileName
            );

            $cigar->setImage($fileName);
            $em->persist($cigar);
            $em->flush($cigar);

            return $this->redirectToRoute('cigar_index', array('id' => $cigar->getId()));
        }

        return $this->render('AppBundle:Cigar:new.html.twig', array(
            'cigar' => $cigar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cigar entity.
     *
     * @Route("/{id}", name="cigar_show")
     * @Method("GET")
     */
    public function showAction(Cigar $cigar)
    {
        $deleteForm = $this->createDeleteForm($cigar);

        return $this->render('AppBundle:Cigar:show.html.twig', array(
            'cigar' => $cigar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cigar entity.
     *
     * @Route("/{id}/edit", name="cigar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cigar $cigar)
    {
        $deleteForm = $this->createDeleteForm($cigar);
        $editForm = $this->createForm('AppBundle\Form\CigarType', $cigar);
        $manu_clone = clone $cigar;

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $cigar->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('cigar_directory'),
                $fileName
            );

            $cigar->setImage($fileName);
            $em->persist($cigar);
            $em->flush($cigar);
            unlink('uploads/cigar/' . $manu_clone->getImage());
            return $this->redirectToRoute('cigar_edit', array('id' => $cigar->getId()));
        }

        return $this->render('AppBundle:Cigar:edit.html.twig', array(
            'cigar' => $cigar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cigar entity.
     *
     * @Route("/{id}", name="cigar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cigar $cigar)
    {
        $form = $this->createDeleteForm($cigar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cigar);
            $em->flush($cigar);
        }

        return $this->redirectToRoute('cigar_index');
    }

    /**
     * Creates a form to delete a cigar entity.
     *
     * @param cigar $cigar The cigar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cigar $cigar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cigar_delete', array('id' => $cigar->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param cigar $cigar
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="cigar_index_delete")
     */
    public function deleteIndexAction(Cigar $cigar)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($cigar);
        $em->flush();
        unlink('uploads/cigar/' . $cigar->getImage());
        return $this->redirectToRoute('cigar_index');
    }
}
