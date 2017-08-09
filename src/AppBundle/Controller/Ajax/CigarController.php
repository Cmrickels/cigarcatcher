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

            $query = $em->createQuery('SELECT c, m, w, s  FROM AppBundle:Cigar c JOIN c.manufacturer m JOIN c.wrapper w JOIN c.shapes s WHERE (c.variant LIKE :search OR c.name LIKE :search)');
            $query->setParameter('search', '%'.$search_string.'%')->setMaxResults(3);
            $results = $query->getResult();

            $htmls = [];
            foreach($results as $result){
                $shapes = $result->getShapes();
                $shapeNames = [];
                $shapeDescriptions = [];
                $shapeImages = [];
                foreach($shapes as $shape){
                    $shapeNames [] = $shape->getName();
                    $shapeDescriptions [] = $shape->getDescription();
                    $shapeImages [] = $shape->getImage();
                }

                $htmls[] = "<div id=". $result->getId() ." class='ddelem draggable' style='float:right'><img style='max-width:70px;' class='img-fluid' src='http://cigarcatcher.dev/uploads/cigar/" . $result->getImage() . "'></div><h4 class='ddelem'><span class=''>Name:</span>" . $result->getVariant() ."</h4><p class='ddelem'>Manufacturer: " . $result->getManufacturer()->getName() . "</p><p class='ddelem'>Body: " . $result->getBody() . "</p><p class='ddelem'>Wrapper: " . $result->getWrapper()->getName() . "</p><p class='ddelem'>Description: " . $result->getDescription() ."</p>";
            }

            if (!empty($htmls)) {
                return new JsonResponse($htmls);
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
            'shapeId'=> $results[0]->getShapes()->getId(),
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