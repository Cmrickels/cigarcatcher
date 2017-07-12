<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Humidor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class HumidorController
 * @package AppBundle\Controller
 * @Route("/humidor")
 */
class HumidorController extends Controller
{

    /**
     * @Route("/show-humidor/{humidorId}", name="humidor")
     */
    public function showHumidorAction($humidorId){
        $user = $this->getUser();
        $selectedHumidor = $this->getDoctrine()->getManager()->getRepository('AppBundle:Humidor')->find($humidorId);
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery('SELECT c, m, w, s  FROM AppBundle:Cigar c JOIN c.manufacturer m JOIN c.wrapper w JOIN c.shape s WHERE c.id = :cigarid ');
//        $query->setParameter('cigarid', $humidorId)->setMaxResults(3);
        return $this->render('AppBundle:Humidor:show-humidor.html.twig', array('user'=> $user, 'humidor'=>$selectedHumidor));
    }


    /**
     * @Route("/humidors", name="list-humidors")
     */
    public function showHumidorsAction(){
        $user = $this->getUser();
        return $this->render('AppBundle:Humidor:humidors.html.twig', array('user'=> $user));
    }


}