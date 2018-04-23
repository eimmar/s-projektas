<?php

namespace App\Controller;

use App\Entity\Vehicles;
use App\Service\AndriausForma;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;

class CreateVehicleController extends Controller
{
    /**
     * @Route("/create_vehicle", name="create_vehicle")
     */
    public function new(Request $request, AndriausForma $andriausForma)
    {
        $user = $this->getUser();
        $request = Request::createFromGlobals();

        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->render('index/index.html.twig', ['var'=>'']);
        }

        $form = $andriausForma->form('post');
        $form->add('modelis', 'select', '', [
            'postfix'=>'<br />',
            'options'=>$andriausForma->choices($andriausForma->models(), 'Automobilio modelis')
        ]);
        $form->add('pavaros', 'select', '', [
            'postfix'=>'<br />',
            'options'=>$andriausForma->choices($andriausForma->transmitions(), 'Pavaros')
        ]);
        $form->add('kuras', 'select', '', [
            'options'=>$andriausForma->choices($andriausForma->fuel(), 'Kuro tipas')
        ]);
        $form->add('galingumas', 'number', '', [
            'prefix'=>'<br />Variklio charakteristikos<br />',
            'postfix'=>'kW<br />',
            'attr'=>'placeholder="Galingumas"',
            'min'=>0
        ]);
        $form->add('kubatura', 'number', '', [
            'postfix'=>'cm<sup>3</sup><br />',
            'attr'=>'placeholder="Darbinis tūris"',
            'min'=>0
        ]);
        $form->add('metai', 'number', '', [
            'prefix'=>'Pagaminimo data<br />',
            'attr'=>'placeholder="Metai"',
            'min'=>1900,
            'max'=>date('Y')
        ]);
        $form->add('menuo', 'number', '', [
            'postfix'=>'<br />',
            'attr'=>'placeholder="Mėnuo"',
            'min'=>1,
            'max'=>12
        ]);
        $form->add('submit', 'submit', '', [
            'attr'=>'value="Pateikti"'
        ]);



        $sub = $request->request->get('submit', null);

        if($sub != null){
            $validated = $form->validate($request->request);
            if($validated === true){
                $entityManager = $this->getDoctrine()->getManager();

                $car = new Vehicles();
                $car->setModelId($this->getDoctrine()->getRepository('App:models')->findOneBy(
                    ['id'=>$request->request->get('modelis')]
                ));
                $car->setUserId($user);
                $car->setPowerKw($request->request->get('galingumas'));
                $car->setTransmitionTypeId($this->getDoctrine()->getRepository('App:transmitionTypes')->findOneBy(
                    ['id'=>$request->request->get('pavaros')]
                ));
                $car->setFuelTypeId($this->getDoctrine()->getRepository('App:fuelTypes')->findOneBy(
                    ['id'=>$request->request->get('kuras')]
                ));
                $car->setEngineCapacity($request->request->get('kubatura'));
                $car->setYearMade($request->request->get('metai'));
                $car->setMonthMade($request->request->get('menuo'));
                $car->setDateCreated(new \DateTime('now'));
                $car->setDateModified(new \DateTime('now'));

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($car);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();

                return $this->render('create_vehicle/index.html.twig', array(
                    'form' => 'Jūsų mašina nusiųsta į duombazę',
                    'error' => ''
                ));
            }else{
                return $this->render('create_vehicle/index.html.twig', array(
                    'form' => $form->generate(),
                    'error' => $validated
                ));
            }
        }

        return $this->render('create_vehicle/index.html.twig', array(
            'form' => $form->generate(),
            'error' => ''
        ));


    }


}
