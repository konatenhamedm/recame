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
     * @Route("/localite", name="localite")
     */
    public function index(LocaliteRepository  $repository, PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Localite::class)->getData();

        return $this->render('admin/localite/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['libelle'=> 'Libelle'],
            'modal' => 'modal',
            'titre' => 'Liste des localite',
            'critereTitre'=>'',

        ]);
    }
    /**
     * @Route("/localite/{id}/show", name="localite_show", methods={"GET"})
     */
    public function show(Localite $localite): Response
    {
        $form = $this->createForm(LocaliteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('localite_show',[
                'id'=>$localite->getId(),
            ])
        ]);

        return $this->render('admin/localite/voir.html.twig', [
            'localite' => $localite,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/localite/new", name="localite_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $localite = new Localite();
        $form = $this->createForm(localiteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('localite_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('localite');

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
            'localite' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/localite/{id}/edit", name="localite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,localite $localite, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(localiteType::class,$localite, [
            'method' => 'POST',
            'action' => $this->generateUrl('localite_edit',[
                'id'=>$localite->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('localite');

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
            'localite' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/localite/delete/{id}", name="localite_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em,localite $localite): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'localite_delete'
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

            $redirect = $this->generateUrl('localite');

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
            'localite' => $localite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/localite/{id}/active", name="localite_active", methods={"GET"})
     */
    public function active($id,Localite $parent, SerializerInterface $serializer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


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
