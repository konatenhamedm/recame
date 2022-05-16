<?php

namespace App\Controller;

use App\Entity\TypeActe;
use App\Form\TypeActeType;
use App\Repository\TypeActeRepository;
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
class TypeActeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     * @param TypeActeRepository $repository
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(TypeActeRepository  $repository, PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(TypeActe::class)->getData();

        return $this->render('admin/type/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['libelle'=> 'Libelle'],
            'modal' => 'modal',
            'titre' => 'Liste des type',
            'critereTitre'=>'',

        ]);
    }

    /**
     * @Route("/type/{id}/show", name="type_show", methods={"GET"})
     * @param TypeActe $TypeActe
     * @return Response
     */
    public function show(TypeActe $TypeActe): Response
    {
        $form = $this->createForm(TypeActeType::class,$TypeActe, [
            'method' => 'POST',
            'action' => $this->generateUrl('type_show',[
                'id'=>$TypeActe->getId(),
            ])
        ]);

        return $this->render('admin/type/voir.html.twig', [
            'titre'=>'TYPE ACTE',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/new", name="type_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $TypeActe = new TypeActe();
        $form = $this->createForm(TypeActeType::class,$TypeActe, [
            'method' => 'POST',
            'action' => $this->generateUrl('type_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('type');

            if($form->isValid()){
                $TypeActe->setActive(1);
                $em->persist($TypeActe);
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

        return $this->render('admin/type/new.html.twig', [
            'titre'=>'TYPE ACTE',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/{id}/edit", name="type_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeActe $TypeActe
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,TypeActe $TypeActe, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(TypeActeType::class,$TypeActe, [
            'method' => 'POST',
            'action' => $this->generateUrl('type_edit',[
                'id'=>$TypeActe->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('type');

            if($form->isValid()){
                $em->persist($TypeActe);
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

        return $this->render('admin/type/edit.html.twig', [
            'titre'=>'TYPE ACTE',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/delete/{id}", name="type_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TypeActe $TypeActe
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,TypeActe $TypeActe): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'type_delete'
                    ,   [
                        'id' => $TypeActe->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($TypeActe);
            $em->flush();

            $redirect = $this->generateUrl('type');

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
        return $this->render('admin/type/delete.html.twig', [
            'type' => $TypeActe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type/{id}/active", name="type_active", methods={"GET"})
     * @param TypeActe $parent
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active(TypeActe $parent, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
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
