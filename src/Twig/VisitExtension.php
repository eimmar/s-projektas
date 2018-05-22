<?php
namespace App\Twig;


class VisitExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getCurrentVisit', [VisitRuntime::class, 'getCurrentVisit']),
        ];
    }
}
