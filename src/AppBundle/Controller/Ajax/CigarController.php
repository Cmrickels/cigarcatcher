<?php

namespace AppBundle\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/nr")
 */
class CigarController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/cmq", name="cigar-manual-query")
     */
    public function manualCigarSearchAction(Request $request){
        $search_string = $request->query->get('search');

        if($search_string != "") {
            $em = $this->getDoctrine()->getManager();

            $repository = $em->getRepository('AppBundle:Cigar');

            $query = $em->createQuery('SELECT c, m, w, s  FROM AppBundle:Cigar c JOIN c.manufacturer m JOIN c.wrapper w JOIN c.shape s WHERE (c.variant LIKE :search OR c.name LIKE :search)');
            $query->setParameter('search', '%'.$search_string.'%')->setMaxResults(3);
            $results = $query->getResult();

            $cigar = array();

            foreach($results as $result){
                $cigars[] = array(
                    'id' => $result->getId(),
                    'gauge' => $result->getGauge(),
                    'body' => $result->getBody(),
                    'wrapperCountry' => $result->getWrapperCountry(),
                    'variant' => $result->getVariant(),
                    'description' => $result->getDescription(),
                    'fillerCountry' => $result->getFillerCountry(),
                    'name' => $result->getName(),
                    'image' => $result->getImage(),
                    'manufacturerId' => $result->getManufacturer()->getId(),
                    'manufacturerName' => $result->getManufacturer()->getName(),
                    'manufacturerDescription' => $result->getManufacturer()->getDescription(),
                    'manufacturerImage' => $result->getManufacturer()->getImage(),
                    'wrapperId' => $result->getWrapper()->getId(),
                    'wrapperName' => $result->getWrapper()->getName(),
                    'wrapperDescription' => $result->getWrapper()->getDescription(),
                    'wrapperColor' => $result->getWrapper()->getColor(),
                    'shapeId' => $result->getShape()->getId(),
                    'shapeName' => $result->getShape()->getName(),
                    'shapeDescription' => $result->getShape()->getDescription(),
                    'shapeImage' => $result->getShape()->getImage(),
                );
            }

            if (!empty($cigars)) {
                return new JsonResponse($cigars);
            } else {
                return new JsonResponse(false);
            }
        }else{
            return new JsonResponse(false);
        }
    }
}