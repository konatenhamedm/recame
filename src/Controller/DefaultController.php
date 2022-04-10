<?php

namespace App\Controller;

use App\Services\PaginationService;
use App\Entity\Groupe;
use App\Entity\Module;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/admin", name="admin", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {

        return $this->render('fils/base.html.twig');
    }

    
    /**
     * @Route("/api", name="api", methods={"GET", "POST"})
     */
    public function  api(Request $request,GroupeRepository $groupeRepository){

     /*   if($request->isXmlHttpRequest()) {*/
            //dd($request->get('mot'));
            $pagination = $groupeRepository->findBy(array('titre'=>'parent'));

      //  }
        return $this->json([
            'code'=>200,
            'message'=>$pagination,
        ],200);
    }
}
