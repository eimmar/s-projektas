<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.2.28
 * Time: 18.20
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $var = mt_rand(0, 100);

        return $this->render('index/index.html.twig', [
            'var' => $var
        ]);
    }
}