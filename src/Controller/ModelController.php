<?php

namespace App\Controller;

use App\Entity\Model;
use App\Form\Model1Type;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/model")
 */
class ModelController extends Controller
{
    /**
     * @Route("/", name="model_index", methods="GET")
     */
    public function index(ModelRepository $modelRepository): Response
    {
        return $this->render('model/index.html.twig', ['models' => $modelRepository->findAll()]);
    }

    /**
     * @Route("/new", name="model_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $model = new Model();
        $form = $this->createForm(Model1Type::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();

            return $this->redirectToRoute('model_index');
        }

        return $this->render('model/new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="model_show", methods="GET")
     */
    public function show(Model $model): Response
    {
        return $this->render('model/show.html.twig', ['model' => $model]);
    }

    /**
     * @Route("/{id}/edit", name="model_edit", methods="GET|POST")
     */
    public function edit(Request $request, Model $model): Response
    {
        $form = $this->createForm(Model1Type::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('model_edit', ['id' => $model->getId()]);
        }

        return $this->render('model/edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="model_delete", methods="DELETE")
     */
    public function delete(Request $request, Model $model): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($model);
            $em->flush();
        }

        return $this->redirectToRoute('model_index');
    }
}
