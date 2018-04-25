<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Repository\ServiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service")
 */
class ServiceController extends Controller
{
    /**
     * @param Request $request
     * @param ServiceRepository $serviceRepository
     * @param ServiceTypeRepository $serviceTypeRepository
     * @Route("/", name="service_index", methods="GET")
     * @return Response
     */
    public function index(
        Request $request,
        ServiceRepository $serviceRepository,
        ServiceTypeRepository $serviceTypeRepository
    ): Response
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $serviceRepository->getBaseListQuery($request->query),
            $request->query->getInt('page', 1),
            $this->container->getParameter('knp_paginator.page_range')
        );

        return $this->render('service/index.html.twig',
            [
                'pagination'   => $pagination,
                'serviceTypes' => $serviceTypeRepository->findAll()
            ]
        );
    }

    /**
     * @Route("/{id}-{slug}", name="service_show", methods="GET")
     */
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', ['service' => $service]);
    }
}
