<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Module;
use App\Entity\ModuleParent;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
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
class DepartementController extends AbstractController
{
    /**
     * @Route("/village", name="village")
     */
    public function index(DepartementRepository  $repository, PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Departement::class)->getData();

        return $this->render('admin/departement/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'Libelle'=> 'Libelle',
                'departement'=> 'departement',

            ],
            'modal'=>'modal',
            'critereTitre'=>'',
        ]);
    }

    /**
     * @Route("/village/{id}/show", name="village_show", methods={"GET"})
     * @param Departement $departement
     * @return Response
     */
    public function show(Departement $departement): Response
    {
        $form = $this->createForm(DepartementType::class,$departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('village_show',[
                'id'=>$departement->getId(),
            ])
        ]);

        return $this->render('admin/departement/voir.html.twig', [
            'village' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/village/new", name="village_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class,$departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('village_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('village');

            if($form->isValid()){
                $departement->setActive(1);
                $em->persist($departement);
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

        return $this->render('admin/departement/new.html.twig', [
            'village' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/village/{id}/edit", name="village_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Departement $departement
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,Departement $departement, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(DepartementType::class,$departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('village_edit',[
                'id'=>$departement->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('village');

            if($form->isValid()){
                $em->persist($departement);
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

        return $this->render('admin/departement/edit.html.twig', [
            'village' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/village/delete/{id}", name="village_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Departement $departement
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Departement $departement): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'village_delete'
                    ,   [
                        'id' => $departement->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($departement);
            $em->flush();

            $redirect = $this->generateUrl('village');

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
        return $this->render('admin/departement/delete.html.twig', [
            'village' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/village/{id}/active", name="village_active", methods={"GET"})
     * @param $id
     * @param Departement $parent
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Departement $parent, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {

        if ($parent->getActive() == 1){

            $parent->setActive(0);

        }else{

            $parent->setActive(1);

        }
      /*  $json = $serializer->serialize($parent, 'json', ['groups' => ['normal']]);*/
        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$parent->getActive(),
        ],200);


    }

}
