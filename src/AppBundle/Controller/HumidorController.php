<?php

namespace AppBundle\Controller;

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
     * @Route("/", name="humidor")
     */
    public function showHumidorAction(){
        return $this->render('AppBundle:Humidor:show-humidor.html.twig');
    }

}