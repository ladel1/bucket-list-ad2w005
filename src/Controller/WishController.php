<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/wish", name="app_wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(WishRepository $wishRepo): Response
    {
        $wishes = $wishRepo->findBy(["isPublished"=>true],["dateCreated"=>"desc"]);
        return $this->render('wish/list.html.twig',compact("wishes"));
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(WishRepository $wishRepo,$id): Response
    {   
        $wish = $wishRepo->find($id);
        return $this->render('wish/detail.html.twig',compact("wish"));
    }

}
