<?php

namespace AppBundle\Controller\Ajax;

use AppBundle\Entity\Experience;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/cigar-info", name="get-cigar-info")
     */
    public function getCigarInfoAction(Request $request){
        $cigarId = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Cigar');

        $query = $em->createQuery('SELECT c, m, w, s  FROM AppBundle:Cigar c JOIN c.manufacturer m JOIN c.wrapper w JOIN c.shape s WHERE c.id = :id');
        $query->setParameter('id', $cigarId );
        $results = $query->getResult();

        $response = new JsonResponse(array(
            'id'=> $results[0]->getId(),
            'gauge'=> $results[0]->getBody(),
            'body'=> $results[0]->getWrapperCountry(),
            'variant' => $results[0]->getVariant(),
            'description'=> $results[0]->getDescription(),
            'fillerCountry'=> $results[0]->getFillerCountry(),
            'manufacturerId'=> $results[0]->getManufacturer()->getId(),
            'manufacturerName'=> $results[0]->getManufacturer()->getName(),
            'manufacturerDescription'=> $results[0]->getManufacturer()->getDescription(),
            'wrapperId'=> $results[0]->getWrapper()->getId(),
            'wrapperName'=> $results[0]->getWrapper()->getName(),
            'wrapperDescription'=> $results[0]->getWrapper()->getDescription(),
            'wrapperColor'=> $results[0]->getWrapper()->getColor(),
            'shapeId'=> $results[0]->getShape()->getId(),
            'shapeName'=> $results[0]->getShape()->getName(),
            'shapeDescription'=> $results[0]->getShape()->getDescription()
        ));
        return $response;
    }


    /**
     * @Route("/add", name="add-experience")
     *
     */
    public function addExperienceAction(Request $request)
    {
        $experienceDescription = $request->request->get('experience');
        $cigarId = $request->request->get('cigar_id');
        $em = $this->getDoctrine()->getManager();

        if(!isset($experienceDescription))
        {
            return new JsonResponse(array('success'=>false, 'message'=>'There is no description set for this experience'));
        }

        $cigar = $em->getRepository('AppBundle:Cigar')->find($cigarId);
        $experience = new Experience();
        $experience->setCigar($cigar);
        $experience->setDescription($experienceDescription);
        $experience->setStatus('pending');
        $experience->setUser($this->getUser());
        $em->persist($experience);
        $em->flush();

        return new JsonResponse(array('success'=>true, 'message'=>'Experience will be reviewed and then added for this cigar. Thank you for your submission!'));
    }

    /**
     * @Route("/experience-get", name="get-experience")
     * @Method({"GET"})
     */
    public function getExperienceAction(Request $request)
    {
        $cigarId = $request->query->get('cigar_id');
        $em = $this->getDoctrine()->getManager();

        $cigar = $em->getRepository('AppBundle:Cigar')->find($cigarId);
        $experiencesQueried = $em->getRepository('AppBundle:Experience')->findBy(array('cigar'=>$cigar, 'status'=>'published'));

        $experiences = array();

        $count = 0;
        foreach($experiencesQueried as $experience)
        {
            $experiences[$count]['description'] = $experience->getDescription();
            $experiences[$count]['submittedBy'] = $experience->getUser()->getUsername();
            $count++;
        }

        return new JsonResponse($experiences);
    }
}