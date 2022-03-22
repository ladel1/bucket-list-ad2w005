<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Wish;
use App\Form\WishType;
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

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request,WishRepository $wishRepo): Response
    {   
        // Création d'objet wish
        $wish = new Wish();
        // Création Formulaire
        $wishForm = $this->createForm(WishType::class,$wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wishRepo->add($wish,true);
            $this->addFlash("success","Idea successfully added!");
            return $this->redirectToRoute("app_wish_detail",["id"=>$wish->getId()]);
        }
        return $this->render('wish/add.html.twig',
            ["wishForm"=>$wishForm->createView()]
        );
    }    


    
    /**
     * @Route("/remove", name="remove")
     */
    public function remove(Request $request,WishRepository $wishRepo): Response
    {

        $token = $request->request->get('_token');
        if($this->isCsrfTokenValid('delete-item',  $token)){
            $id = $request->request->get('id');
            $wish = $wishRepo->find($id);
            $wishRepo->remove($wish);
            $this->addFlash("success","Wish with Id='$id' has been removed");
        }
        
        return $this->redirectToRoute("app_wish_list");

    } 

}
