<?php

namespace App\Controller;

use App\Entity\Localite;
use App\Form\LocaliteType;
use App\Repository\LocaliteRepository;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/admin")
 */
class LocaliteController extends AbstractController
{
    /**
     * @Route("/departement", name="departement")
     * @param LocaliteRepository $repository
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(LocaliteRepository  $repository, PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Localite::class)->getData();

        return $this->render('admin/localite/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['libelle'=> 'Libelle'],
            'modal' => 'modal',
            'titre' => 'Liste des departement',
            'critereTitre'=>'',

        ]);
    }

    /**
     * @Route("/departement/{id}/show", name="departement_show", methods={"GET"})
     * @param Localite $localite
     * @return Response
     */
    public function show(Localite $localite): Response
    {
        $form = $this->createForm(LocaliteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('departement_show',[
                'id'=>$localite->getId(),
            ])
        ]);

        return $this->render('admin/localite/voir.html.twig', [
            'departement' => $localite,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/departement/new", name="departement_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $localite = new Localite();
        $form = $this->createForm(LocaliteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('departement_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('departement');

            if($form->isValid()){
                $localite->setActive(1);
                $em->persist($localite);
                $em->flush();

                $message       = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }
            if ($isAjax) {
                return $this->json( compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/localite/new.html.twig', [
            'departement' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/departement/{id}/edit", name="departement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Localite $localite, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(LocaliteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('departement_edit',[
                'id'=>$localite->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('departement');

            if($form->isValid()){
                $em->persist($localite);
                $em->flush();

                $message       = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }

            if ($isAjax) {
                return $this->json( compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/localite/edit.html.twig', [
            'departement' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/departement/delete/{id}", name="departement_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Localite $localite
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Localite $localite): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'departement_delete'
                    ,   [
                        'id' => $localite->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($localite);
            $em->flush();

            $redirect = $this->generateUrl('departement');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut'   => 1,
                'message'  => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }



        }
        return $this->render('admin/localite/delete.html.twig', [
            'departement' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/departement/{id}/active", name="departement_active", methods={"GET"})
     * @param $id
     * @param Localite $parent
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Localite $parent, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {


        if ($parent->getActive() == 1){

            $parent->setActive(0);

        }else{

            $parent->setActive(1);

        }
        $json = $serializer->serialize($parent, 'json', ['groups' => ['normal']]);
        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$parent->getActive(),
        ],200);


    }

}
