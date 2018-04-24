<?php

namespace App\Controller;

use App\Entity\ServiceType;
use App\Repository\ServiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service-type")
 */
class ServiceTypeController extends Controller
{

    /**
     * @param ServiceType $serviceType
     * @param Request $request
     * @param $serviceTypeRepository $serviceRepository
     * @Route("/{id}-{slug}", name="service_type_index", methods="GET")
     * @return Response
     */
    public function show(ServiceType $serviceType, Request $request, ServiceTypeRepository $serviceTypeRepository): Response
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $serviceTypeRepository->getServiceListQuery($serviceType),
            $request->query->getInt('page', 1),
            $this->container->getParameter('knp_paginator.page_range')
        );

        return $this->render('service/index.html.twig',
            [
                'pagination'  => $pagination,
                'serviceTypes' => $serviceTypeRepository->findAll()
            ]
        );
    }
}
