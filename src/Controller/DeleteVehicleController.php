<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeleteVehicleController extends Controller
{
    /**
     * @Route("/delete_vehicle/{id}", name="delete_vehicle", requirements={"id"="\d+"}))
     */
    public function index($id)
    {
        $user = $this->getUser();
        $vehicle = $this->getDoctrine()->getRepository('App:Vehicle')->findBy(['id'=>$id]);
        $vehicle = $vehicle[0];
        if($vehicle->getUser() == $user){
            $this->getDoctrine()->getManager()->remove($vehicle);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirect('../edit_vehicle');
    }
}
