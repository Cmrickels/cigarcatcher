<?php
/**
 * Created by PhpStorm.
 * User: crickels
 * Date: 6/21/17
 * Time: 3:52 PM
 */

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ExperienceController extends Controller
{
    /**
     * @Route("/all-experiences", name="all-experiences")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $experiences = $this->getDoctrine()->getManager()->getRepository('AppBundle\Entity\Experience')->findBy(array(), array('submissionDate'=>'ASC'));
        return $this->render('AppBundle:Experience:index.html.twig', array(
            'experiences'=>$experiences,
        ));
    }

    /**
     * @param $id
     * @param $status
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/approve-experience/{id}/{status}", name="approve-experience", defaults={"status":"published"})
     */
    public function publishEraseExperience($id, $status)
    {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('AppBundle\Entity\Experience')->find($id);

        if($status == 'publish') {
            $experience->setStatus('published');
            $em->persist($experience);
            $em->flush();
        }elseif($status == 'erase')
        {
            $em->remove($experience);
            $em->flush();
        }

        return $this->redirectToRoute('all-experiences');
    }

}