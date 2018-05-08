<?php

namespace App\Controller;

use App\Entity\Visits;
use App\Service\VisitForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;

class CreateVisitController extends Controller
{
    /**
     * @Route("/create_visit", name="create_visit")
     */
    public function new(Request $request, VisitForm $serviceVisitPage)
    {
        $user = $this->getUser();
        $request = Request::createFromGlobals();

        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->render('index/index.html.twig', ['var'=>'']);
        }

        $form = $serviceVisitPage->form('post');
        $form->add('data', 'select', '', [
            'postfix'=>'<br />',
//?????            'options'=>$serviceVisitPage->choices($serviceVisitPage->models(), 'Data')
        ]);
        $form->add('automobiliai', 'select', '', [
            'postfix'=>'<br />',
            'options'=>$serviceVisitPage->choices($serviceVisitPage->vehicle(), 'Automobiliai')
        ]);
        $form->add('busena', 'select', '', [
            'postfix'=>'<br />',
            'options'=>$serviceVisitPage->choices($serviceVisitPage->status(),'Busena')
        ]);
        $form->add('paslauga', 'select', '', [
            'options'=>$serviceVisitPage->choices($serviceVisitPage->service(), 'Paslauga')
        ]);
        $form->add('submit', 'submit', '', [
            'attr'=>'value="Pateikti"'
        ]);



        $sub = $request->request->get('submit', null);

        if($sub != null){
            $validated = $form->validate($request->request);
            if($validated === true){
                $entityManager = $this->getDoctrine()->getManager();

                $visit = new Visits();

                $visit->setVisitDate($request->request->get('vizito_data'));
                $visit->setVehicleId($this->getDoctrine()->getRepository('App:vehicles')->findOneBy(
                    ['id'=>$request->request->get('automobilis')]));
                $visit->setStatusId($this->getDoctrine()->getRepository('App:visitStatuses')->findOneBy(
                    ['id'=>$request->request->get('vizito_statusas')]
                ));
                $visit->setDateCreated(new \DateTime('now'));
                $visit->setDateModified(new \DateTime('now'));

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($visit);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();

                return $this->render('create_visit/index.html.twig', array(
                    'form' => 'Jūsų visitas nusiųstas į duombazę',
                    'error' => ''
                ));
            }else{
                return $this->render('create_visit/index.html.twig', array(
                    'form' => $form->generate(),
                    'error' => $validated
                ));
            }
        }

        return $this->render('create_visit/index.html.twig', array(
            'form' => $form->generate(),
            'error' => ''
        ));


    }


}
