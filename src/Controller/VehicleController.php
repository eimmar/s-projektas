<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Security\VehicleVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle")
 * @Security("has_role('ROLE_USER')")
 */
class VehicleController extends Controller
{
    /**
     * @Route("/", name="vehicle_index", methods="GET")
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('vehicle/index.html.twig', ['vehicles' => $user->getVehicles()]);
    }

    /**
     * @Route("/new", name="vehicle_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setUser($this->get('security.token_storage')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush();

            return $this->redirectToRoute('vehicle_index');
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicle_show", methods="GET")
     */
    public function show(Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::VIEW, $vehicle);

        return $this->render('vehicle/show.html.twig', ['vehicle' => $vehicle]);
    }

    /**
     * @Route("/{id}/edit", name="vehicle_edit", methods="GET|POST")
     */
    public function edit(Request $request, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::EDIT, $vehicle);

        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_edit', ['id' => $vehicle->getId()]);
        }

        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicle_delete", methods="DELETE")
     */
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted(VehicleVoter::DELETE, $vehicle);

        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicle);
            $em->flush();
        }

        return $this->redirectToRoute('vehicle_index');
    }
}
