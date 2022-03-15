<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(): Response
    {
        $menu = ["Accueil"=>"app_main","Contact"=>"#","Bucket List"=>"#"];
        return $this->render('main/home.html.twig',compact("menu"));
    }
}
