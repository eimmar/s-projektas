<?php

namespace App\Controller;

use App\Service\VisitForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AndriausForma;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class EditVisitController extends Controller
{


    /**
     * @Route("/edit_visit/{id}", name="edit_visit", requirements={"id"="\d+"}))
     */
    public function main($id = 0, VisitForm $serviceVisitPage)
    {
        $user = $this->getUser();
        $request = Request::createFromGlobals();

        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->render('index/index.html.twig', ['var'=>'']);
        }
        $ids = $this->getDoctrine()->getRepository('App:visits')->findBy(['user_id'=>$user->getId()]);
        $urls = array_map(function($x){
            return
                [
                    'id'=>$x->getId(),
                    'name'=>$this->getDoctrine()->getRepository('App:models')->findOneBy(['id'=>$x->getModelId()])->getName()
                ];
        }, $ids);
        if($id == 0){
            return $this->render('edit_visit/index.html.twig', [
                'urls' => $urls,
            ]);
        }elseif(count($vehicle = array_filter($ids, function ($x) use($id){
            return $x->getId() == $id;
        })) > 0){
            $visit = reset($visit);
            $form = $serviceVisitPage->form('post');
            $form->add('data', 'select', '', [
                'postfix'=>'<br />',
//??????            'options'=>$serviceVisitPage->choices($serviceVisitPage->models(), 'Data')
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
                    $visit = $entityManager->getRepository(Visits::class)->find($id);
                    if (!$visit) {
                        throw $this->createNotFoundException(
                            'No product found for id '.$id
                        );
                    }

                    $visit->setVisitDate($request->request->get('vizito_data'));
                    $visit->setVehicleId($this->getDoctrine()->getRepository('App:vehicles')->findOneBy(
                        ['id'=>$request->request->get('automobilis')]));
                    $visit->setStatusId($this->getDoctrine()->getRepository('App:visitStatuses')->findOneBy(
                        ['id'=>$request->request->get('visito_statusas')]
                    ));
                    $visit->setDateCreated(new \DateTime('now'));
                    $visit->setDateModified(new \DateTime('now'));
                    $entityManager->persist($visit);


                    $entityManager->flush();

                    return $this->render('create_visit/index.html.twig', array(
                        'form' => '<br /><a href="/edit_visit">Peržiūrėti užregistruotus vizitus</a>',
                        'error' => 'Jūsų vizitas atnaujintas'
                    ));
                }else{
                    return $this->render('create_visit/index.html.twig', array(
                        'form' => $form->generate(),
                        'error' => $validated
                    ));
                }
            }else{
                return $this->render('create_visit/index.html.twig', array(
                    'form' => $form->generate(),
                    'error' => ''
                ));
            }
        }
        return $this->render('index/index.html.twig', ['var'=>'']);
    }
}
