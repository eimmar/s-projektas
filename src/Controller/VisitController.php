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
     * @Route("/arrange", name="visit_arrange", methods="GET|POST")
     */
    public function new(Request $request, VisitArranger $visitArranger): Response
    {
        if (!$visitArranger->userHasVehicles()) {
            $this->addFlash('warning', 'visit.create.arrangement_no_vehicle_available');
            return $this->redirectToRoute('vehicle_new');
        }

        $visit = $visitArranger->initVisit($request->get('add_service'));
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($visitArranger->isVisitValid($visit) && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $response = $this->render('visit/edit.html.twig', [
                'visit' => $visit,
                'form' => $form->createView(),
            ]);
        } else if ($visitArranger->isVisitValid($visit)) {
            $response = $this->render('visit/edit.html.twig', [
                'visit' => $visit,
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('warning', 'visit.create.arrangement_no_services_added');
            $response = $this->redirectToRoute('service_index');
        }

        return $response;
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
     * @Route("/cancel", name="visit_cancel", methods="CANCEL")
     */
    public function cancel(Request $request, VisitArranger $arranger): Response
    {
        $visit = $arranger->initVisit();
        $this->denyAccessUnlessGranted(VehicleVoter::DELETE, $visit->getVehicle());

        if ($this->isCsrfTokenValid('cancel'.$visit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visit);
            $em->flush();
        }

        return $this->redirectToRoute('visit_index');
    }

    /**
     * @Route("/{id}", name="visit_submit", methods="SUBMIT")
     */
    public function submit(Request $request, Visit $visit): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::EDIT, $visit->getVehicle());

        if ($this->isCsrfTokenValid('submit'.$visit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
        }

        return $this->redirectToRoute('visit_index');
    }
}
