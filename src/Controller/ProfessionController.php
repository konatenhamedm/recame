<?php

namespace App\Controller;

use App\Entity\Profession;
use App\Form\ProfessionType;
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
class ProfessionController extends AbstractController
{
    /**
     * @Route("/profession", name="profession")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Profession::class)->getData();

        return $this->render('admin/profession/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['libelle'=> 'Libelle'],
            'modal' => 'modal',
            'titre' => 'Liste des professions',
            'critereTitre'=>'',

        ]);
    }
    /**
     * @Route("/profession/{id}/show", name="profession_show", methods={"GET"})
     */
    public function show(Profession $profession): Response
    {
        $form = $this->createForm(ProfessionType::class,$profession, [
            'method' => 'POST',
            'action' => $this->generateUrl('profession_show',[
                'id'=>$profession->getId(),
            ])
        ]);

        return $this->render('admin/profession/voir.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/profession/new", name="profession_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $profession = new Profession();
        $form = $this->createForm(ProfessionType::class,$profession, [
            'method' => 'POST',
            'action' => $this->generateUrl('profession_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('profession');

            if($form->isValid()){
                $profession->setActive(1);
                $em->persist($profession);
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

        return $this->render('admin/profession/new.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profession/{id}/edit", name="profession_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Profession $profession, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(ProfessionType::class,$profession, [
            'method' => 'POST',
            'action' => $this->generateUrl('profession_edit',[
                'id'=>$profession->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('profession');

            if($form->isValid()){
                $em->persist($profession);
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

        return $this->render('admin/profession/edit.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profession/delete/{id}", name="profession_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em,Profession $profession): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'profession_delete'
                    ,   [
                        'id' => $profession->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($profession);
            $em->flush();

            $redirect = $this->generateUrl('profession');

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
        return $this->render('admin/profession/delete.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profession/{id}/active", name="profession_active", methods={"GET"})
     */
    public function active($id,Profession $parent, SerializerInterface $serializer): Response
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
