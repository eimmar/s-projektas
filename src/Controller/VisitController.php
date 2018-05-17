<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use App\Security\VehicleVoter;
use App\Service\VisitArranger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visit")
 * @Security("has_role('ROLE_USER')")
 */
class VisitController extends Controller
{
    /**
     * @Route("/", name="visit_index", methods="GET")
     */
    public function index(VisitRepository $visitRepository): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('visit/index.html.twig', ['visits' => $visitRepository->findActiveVisits($user)]);
    }

    /**
     * @Route("/new", name="visit_new", methods="GET|POST")
     */
    public function new(Request $request, VisitArranger $visitArranger): Response
    {
        $visit = $visitArranger->initVisit($request->get('add_service'));
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($visitArranger->isVisitValid($visit)) {

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('visit_edit', ['id' => $visit->getId()]);
            }

            return $this->render('visit/edit.html.twig', [
                'visit' => $visit,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('index/index.html.twig');
        }
    }

    /**
     * @Route("/{id}", name="visit_show", methods="GET")
     */
    public function show(Visit $visit): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::VIEW, $visit->getVehicle());
        return $this->render('visit/show.html.twig', ['visit' => $visit]);
    }

    /**
     * @Route("/{id}/edit", name="visit_edit", methods="GET|POST")
     */
    public function edit(Request $request, Visit $visit): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::EDIT, $visit->getVehicle());
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('visit_edit', ['id' => $visit->getId()]);
        }

        return $this->render('visit/edit.html.twig', [
            'visit' => $visit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="visit_delete", methods="DELETE")
     */
    public function delete(Request $request, Visit $visit): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::DELETE, $visit->getVehicle());

        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visit);
            $em->flush();
        }

        return $this->redirectToRoute('visit_index');
    }
}
