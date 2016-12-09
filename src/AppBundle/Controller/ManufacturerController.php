<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Manufacturer;
use AppBundle\Form\ManufacturerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Manufacturer controller.
 *
 * @Route("manufacturer")
 */
class ManufacturerController extends Controller
{
    /**
     * Lists all manufacturer entities.
     *
     * @Route("/", name="manufacturer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $manufacturers = $em->getRepository(Manufacturer::class)->findAll();

        return $this->render('AppBundle:Manufacturer:index.html.twig', array(
            'manufacturers' => $manufacturers,
        ));
    }

    /**
     * Creates a new manufacturer entity.
     *
     * @Route("/new", name="manufacturer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $form = $this->createForm(ManufacturerType::class, $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file = $manufacturer->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('manufacturer_directory'),
                $fileName
            );

            $manufacturer->setImage($fileName);
            $em->persist($manufacturer);
            $em->flush($manufacturer);

            return $this->redirectToRoute('manufacturer_index', array('id' => $manufacturer->getId()));
        }

        return $this->render('AppBundle:Manufacturer:new.html.twig', array(
            'manufacturer' => $manufacturer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a manufacturer entity.
     *
     * @Route("/{id}", name="manufacturer_show")
     * @Method("GET")
     */
    public function showAction(Manufacturer $manufacturer)
    {
        $deleteForm = $this->createDeleteForm($manufacturer);

        return $this->render('AppBundle:Manufacturer:show.html.twig', array(
            'manufacturer' => $manufacturer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing manufacturer entity.
     *
     * @Route("/{id}/edit", name="manufacturer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Manufacturer $manufacturer)
    {
        $deleteForm = $this->createDeleteForm($manufacturer);
        $editForm = $this->createForm('AppBundle\Form\ManufacturerType', $manufacturer);
        $manu_clone = clone $manufacturer;

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $manufacturer->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('manufacturer_directory'),
                $fileName
            );

            $manufacturer->setImage($fileName);
            $em->persist($manufacturer);
            $em->flush($manufacturer);
            unlink('uploads/manufacturer/' . $manu_clone->getImage());
            return $this->redirectToRoute('manufacturer_edit', array('id' => $manufacturer->getId()));
        }

        return $this->render('AppBundle:Manufacturer:edit.html.twig', array(
            'manufacturer' => $manufacturer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a manufacturer entity.
     *
     * @Route("/{id}", name="manufacturer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Manufacturer $manufacturer)
    {
        $form = $this->createDeleteForm($manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($manufacturer);
            $em->flush($manufacturer);
        }

        return $this->redirectToRoute('manufacturer_index');
    }

    /**
     * Creates a form to delete a manufacturer entity.
     *
     * @param Manufacturer $manufacturer The manufacturer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Manufacturer $manufacturer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manufacturer_delete', array('id' => $manufacturer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param Manufacturer $manufacturer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete/{id}", name="manufacturer_index_delete")
     */
    public function deleteIndexAction(Manufacturer $manufacturer){
        $em = $this->getDoctrine()->getManager();
        $em->remove($manufacturer);
        $em->flush();
        unlink('uploads/manufacturer/' . $manufacturer->getImage());
        return $this->redirectToRoute('manufacturer_index');
    }
}
