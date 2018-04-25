<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.2.28
 * Time: 18.20
 */
namespace App\Controller;

use App\Form\SearchType;
use App\Utils\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $var = mt_rand(0, 100);

        return $this->render('index/index.html.twig', [
            'var' => $var
        ]);
    }

    /**
     * @return Response
     */
    public function search(Request $request)
    {
        $form = $this->createForm(SearchType::class, new Search());
        $form->handleRequest($request);

        return $this->render('index/search.html.twig', ['form' => $form->createView()]);
    }
}
