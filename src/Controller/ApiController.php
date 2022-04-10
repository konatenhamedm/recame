<?php

namespace App\Controller;

use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api",methods={"GET"})
     * la normalisation consiste a transformer un objet a un tableau assiciatif
     */
    public function index(GroupeRepository $groupeRepository,NormalizerInterface $normalizer)
    {
        $group = $groupeRepository->findAll();
        dd($normalizer->normalize($group,null,["groups"=>"groupe:read"]));
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
