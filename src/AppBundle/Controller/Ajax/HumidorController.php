<?php

namespace AppBundle\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Humidor;

/**
 * @Route("/hc")
 */
class HumidorController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/cmq", name="attach-cigar-to-slot")
     */
    public function cigarToSlotAction(Request $request){
        $cigarId = $request->query->get('cigarId');
        $slotId = $request->query->get('slotId');
        $humidorId = $request->query->get('humidorId');

        $em = $this->getDoctrine()->getManager();
        $cigar = $em->getRepository('AppBundle:Cigar')->find($cigarId);
        $selectedHumidor = $em->getRepository('AppBundle:Humidor')->find($humidorId);
        $user = $selectedHumidor->getUser();

        switch ($slotId) {
            case 'slot1':
                $selectedHumidor->setSlot1($cigar);
                $selectedHumidor->setSlot1TimeAdded(new \DateTime());
                break;
            case 'slot2':
                $selectedHumidor->setSlot2($cigar);
                $selectedHumidor->setSlot2TimeAdded(new \DateTime());
                break;
            case 'slot3':
                $selectedHumidor->setSlot3($cigar);
                $selectedHumidor->setSlot3TimeAdded(new \DateTime());
                break;
            case 'slot4':
                $selectedHumidor->setSlot4($cigar);
                $selectedHumidor->setSlot4TimeAdded(new \DateTime());
                break;
            case 'slot5':
                $selectedHumidor->setSlot5($cigar);
                $selectedHumidor->setSlot5TimeAdded(new \DateTime());
                break;
            case 'slot6':
                $selectedHumidor->setSlot6($cigar);
                $selectedHumidor->setSlot6TimeAdded(new \DateTime());
                break;
            case 'slot7':
                $selectedHumidor->setSlot7($cigar);
                $selectedHumidor->setSlot7TimeAdded(new \DateTime());
                break;
            case 'slot8':
                $selectedHumidor->setSlot8($cigar);
                $selectedHumidor->setSlot8TimeAdded(new \DateTime());
                break;
            default:

        }

        $em->persist($selectedHumidor);
        $em->flush($selectedHumidor);

        $data = array();
        $data[] = array('cigarId'=>$cigarId, 'slotId'=>$slotId);

        return new JsonResponse($data);
    }

    /**
     * @Route("/createHumidor", name="create-humidor")
     */
    public function createHumidorAction(Request $request){
        $humidorName = $request->query->get('humidorName');

        $humidor = new Humidor();
        $humidor->setName($humidorName);

        $user = $this->getUser();
        $user->addHumidors($humidor);
        $humidor->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        try{
            $em->flush($user);
            return JsonResponse::create("success");
        }catch(\Exception $e){
            return JsonResponse::create($e->getMessage());
        }

    }


}