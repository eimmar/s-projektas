<?php

namespace App\Controller;

use App\Entity\Models;
use App\Entity\Vehicle;
use App\Entity\Vehicles;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AndriausForma;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class EditVehicleController extends Controller
{


    /**
     * @Route("/edit_vehicle/{id}", name="edit_vehicle", requirements={"id"="\d+"}))
     */
    public function main($id = 0, AndriausForma $andriausForma)
    {
        $user = $this->getUser();
        $request = Request::createFromGlobals();

        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->render('index/index.html.twig', ['var'=>'']);
        }
        $ids = $this->getDoctrine()->getRepository('App:Vehicle')->findBy(['user'=>$user->getId()]);
        $urls = array_map(function($x){
            return
                [
                    'id'=>$x->getId(),
                    'name'=>$this->getDoctrine()->getRepository('App:Model')->findOneBy(['id'=>$x->getModel()])->getName()
                ];
        }, $ids);
        if($id == 0) {
            return $this->render('edit_vehicle/index.html.twig', [
                'urls' => $urls,
            ]);
        }elseif(count($vehicle = array_filter($ids, function ($x) use($id){
            return $x->getId() == $id;
        })) > 0){
            $vehicle = reset($vehicle);
            $form = $andriausForma->form('post');
            $form->add('modelis', 'select', '', [
                'postfix'=>'<br />',
                'options'=>$andriausForma->choices($andriausForma->models(), 'Automobilio modelis'),
                'value'=>$vehicle->getModel()->getId()
            ]);
            $form->add('pavaros', 'select', '', [
                'postfix'=>'<br />',
                'options'=>$andriausForma->choices($andriausForma->transmissions(), 'Pavaros'),
                'value'=>$vehicle->getTransmissionType()->getId()
            ]);
            $form->add('kuras', 'select', '', [
                'options'=>$andriausForma->choices($andriausForma->fuel(), 'Kuro tipas'),
                'value'=>$vehicle->getFuelType()->getId()
            ]);
            $form->add('galingumas', 'number', '', [
                'prefix'=>'<br />Variklio charakteristikos<br />',
                'postfix'=>'kW<br />',
                'attr'=>'placeholder="Galingumas"',
                'min'=>0,
                'value'=>$vehicle->getPowerKw()
            ]);
            $form->add('kubatura', 'number', '', [
                'postfix'=>'cm<sup>3</sup><br />',
                'attr'=>'placeholder="Darbinis tūris"',
                'min'=>0,
                'value'=>$vehicle->getEngineCapacity()
            ]);
            $form->add('metai', 'number', '', [
                'prefix'=>'Pagaminimo data<br />',
                'attr'=>'placeholder="Metai"',
                'min'=>1900,
                'max'=>date('Y'),
                'value'=>$vehicle->getYearMade()
            ]);
            $form->add('menuo', 'number', '', [
                'postfix'=>'<br />',
                'attr'=>'placeholder="Mėnuo"',
                'min'=>1,
                'max'=>12,
                'value'=>$vehicle->getMonthMade()
            ]);
            $form->add('submit', 'submit', '', [
                'value'=>"Pateikti"
            ]);

            $sub = $request->request->get('submit', null);

            if($sub != null){
                $validated = $form->validate($request->request);
                if($validated === true){
                    $entityManager = $this->getDoctrine()->getManager();
                    $car = $entityManager->getRepository(Vehicle::class)->find($id);
                    if (!$car) {
                        throw $this->createNotFoundException(
                            'No product found for id '.$id
                        );
                    }
                    $car->setModel($this->getDoctrine()->getRepository('App:model')->findOneBy(
                        ['id'=>$request->request->get('modelis')]
                    ));
                    $car->setPowerKw($request->request->get('galingumas'));
                    $car->setTransmissionType($this->getDoctrine()->getRepository('App:transmissionType')->findOneBy(
                        ['id'=>$request->request->get('pavaros')]
                    ));
                    $car->setFuelType($this->getDoctrine()->getRepository('App:fuelType')->findOneBy(
                        ['id'=>$request->request->get('kuras')]
                    ));
                    $car->setEngineCapacity($request->request->get('kubatura'));
                    $car->setYearMade($request->request->get('metai'));
                    $car->setMonthMade($request->request->get('menuo'));
                    $car->setDateModified(new \DateTime('now'));
                    $entityManager->persist($car);


                    $entityManager->flush();

                    return $this->render('create_vehicle/index.html.twig', array(
                        'form' => '<br /><a href="/edit_vehicle">Peržiūrėti užregistruotus automobilius</a>',
                        'error' => 'Jūsų mašina atnaujinta',
                        'controller_name' => 'Edit Vehicle'
                    ));
                }else{
                    return $this->render('create_vehicle/index.html.twig', array(
                        'form' => $form->generate(),
                        'error' => $validated,
                        'controller_name' => 'Edit Vehicle'
                    ));
                }
            }else{
                return $this->render('create_vehicle/index.html.twig', array(
                    'form' => $form->generate(),
                    'error' => '',
                    'controller_name' => 'Edit Vehicle'
                ));
            }
        }
        return $this->render('index/index.html.twig', ['var'=>'']);
    }
}
