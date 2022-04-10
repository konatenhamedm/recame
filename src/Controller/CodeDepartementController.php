<?php

namespace App\Controller;

use App\Entity\CodeDepartement;
use App\Form\CodeDepartementType;
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
class CodeDepartementController extends AbstractController
{
    /**
     * @Route("/code_departement", name="code_departement")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(CodeDepartement::class)->getData();

        return $this->render('admin/code_departement/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => ['libelle'=> 'Libelle'],
            'modal'=>'modal'


        ]);
    }
    /**
     * @Route("/code_departement/{id}/show", name="code_departement_show", methods={"GET"})
     */
    public function show(CodeDepartement $code_departement): Response
    {
        $form = $this->createForm(CodeDepartementType::class,$code_departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('code_departement_show',[
                'id'=>$code_departement->getId(),
            ])
        ]);

        return $this->render('admin/code_departement/voir.html.twig', [
            'code_departement' => $code_departement,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/code_departement/new", name="code_departement_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em): Response
    {
        $code_departement = new CodeDepartement();
        $form = $this->createForm(CodeDepartementType::class,$code_departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('code_departement_new')
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('code_departement');

            if($form->isValid()){
                $code_departement->setActive(1);
                $em->persist($code_departement);
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

        return $this->render('admin/code_departement/new.html.twig', [
            'code_departement' => $code_departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/code_departement/{id}/edit", name="code_departement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,CodeDepartement $code_departement, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(CodeDepartementType::class,$code_departement, [
            'method' => 'POST',
            'action' => $this->generateUrl('code_departement_edit',[
                'id'=>$code_departement->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $redirect = $this->generateUrl('code_departement');

            if($form->isValid()){
                $em->persist($code_departement);
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

        return $this->render('admin/code_departement/edit.html.twig', [
            'code_departement' => $code_departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/code_departement/delete/{id}", name="code_departement_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em,CodeDepartement $code_departement): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'code_departement_delete'
                    ,   [
                        'id' => $code_departement->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($code_departement);
            $em->flush();

            $redirect = $this->generateUrl('code_departement');

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
        return $this->render('admin/code_departement/delete.html.twig', [
            'code_departement' => $code_departement,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/parent/{id}/active", name="code_departement_active", methods={"GET"})
     */
    public function active($id,EntityManagerInterface $em,CodeDepartement $parent, SerializerInterface $serializer): Response
    {

        if ($parent->getActive() == 1){

            $parent->setActive(0);

        }else{

            $parent->setActive(1);

        }
        $json = $serializer->serialize($parent, 'json', ['groups' => ['normal']]);
        $em->persist($parent);
        $em->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$parent->getActive(),
        ],200);


    }

}
