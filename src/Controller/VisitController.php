<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use App\Security\VehicleVoter;
use App\Service\VisitArranger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->render('visit/index.html.twig', ['visits' => $visitRepository->findUserVisits($user)]);
    }

    /**
     * @Route("/arrange", name="visit_arrange", methods="GET|POST")
     */
    public function arrange(Request $request, VisitArranger $arranger): Response
    {
        if (!$arranger->userHasVehicles()) {
            $this->addFlash('warning', 'visit.arrange.arrangement_no_vehicle_available');
            return $this->redirectToRoute('vehicle_new');
        }

        $visit = $arranger->initVisit($request->get('add_service'));
        $form = $this->createForm(VisitType::class, $visit);

        if ($arranger->isVisitValid($visit)) {
            $response = $this->render('visit/arrange.html.twig', [
                'visit' => $visit,
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('warning', 'visit.arrange.arrangement_no_services_added');
            $response = $this->redirectToRoute('service_index');
        }

        return $response;
    }

    /**
     * @Route("/update", name="visit_update", methods="POST", condition="request.isXmlHttpRequest()")
     */
    public function update(Request $request, VisitArranger $arranger)
    {
        $visit = $arranger->initVisit();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $visit->calculateTotals();
            $manager->persist($visit);
            $manager->flush();
            $response = new JsonResponse(
                [
                    'success' => true,
                    'html' => $this->render('visit/arrange.html.twig', [
                        'visit' => $visit,
                        'form' => $form->createView(),
                    ])->getContent()
                ]
            );
        } else {
            $response = new JsonResponse(['success' => false]);
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

        if ($visit && $this->isCsrfTokenValid('cancel'.$visit->getId(), $request->request->get('_token'))) {
            $arranger->cancel($visit);
            $this->addFlash('success', 'visit.arrange.arrangement_cancelled');
        }

        return $this->redirectToRoute('visit_index');
    }

    /**
     * @Route("/submit", name="visit_submit", methods="SUBMIT")
     */
    public function submit(Request $request, VisitArranger $arranger): Response
    {
        $visit = $arranger->initVisit();

        if ($visit && $this->isCsrfTokenValid('submit'.$visit->getId(), $request->request->get('_token'))) {
            $arranger->submit($visit);
            $this->addFlash('success', 'visit.arrange.arrangement_submitted');
        }

        return $this->redirectToRoute('visit_index');
    }
}
