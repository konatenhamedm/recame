<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/admin")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(categorie::class)->getData();

        return $this->render('admin/categorie/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'image'=> 'image',
                'libelle'=> 'libelle',
                'stock'=> 'stock',
            ],
            'critereTitre'=>'',
            'modal' => 'modal',
            'position' => 4,
            'active'=> 3,
            'titre' => 'Liste des categories',

        ]);
    }
    /**
     * @Route("/categorie/{id}/show", name="categorie_show", methods={"GET"})
     */
    public function show(categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class,$categorie, [
            'method' => 'POST',
            'action' => $this->generateUrl('categorie_show',[
                'id'=>$categorie->getId(),
            ])
        ]);

        return $this->render('admin/categorie/voir.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/new", name="categorie_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param CategorieRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper,CategorieRepository $repository): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class,$categorie ,[
            'method' => 'POST',
            'action' => $this->generateUrl('categorie_new')
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted() && $form->isValid())
        {
            $response = [];
            $statut = 1;
            $redirect = $this->generateUrl('categorie');


                $uploadedFile = $form['image']->getData();
//dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $categorie->setImage($newFilename);
                }
                $categorie->setActive(1);
                $em->persist($categorie);
                $em->flush();

                $message       = 'Opération effectuée avec succès';

                $this->addFlash('success', $message);

            if ($isAjax) {
                return $this->json( compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id}/edit", name="categorie_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Categorie $categorie
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return void
     */
    public function edit(Request $request,Categorie $categorie, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper): Response
    {

        $form = $this->createForm(CategorieType::class,$categorie, [
            'method' => 'POST',
            'action' => $this->generateUrl('categorie_edit',[
                'id'=>$categorie->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('categorie');

            if($form->isValid()){
                $uploadedFile = $form['image']->getData();
dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $categorie->setImage($newFilename);
                }
                $em->persist($categorie);
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

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/delete/{id}", name="categorie_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Categorie $categorie
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Categorie $categorie): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'categorie_delete'
                    ,   [
                        'id' => $categorie->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($categorie);
            $em->flush();

            $redirect = $this->generateUrl('categorie');

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
        return $this->render('admin/categorie/delete.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id}/active", name="categorie_active", methods={"GET"})
     */
    public function active($id,Categorie $categorie, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {

        if ($categorie->getActive() == 1){

            $categorie->setActive(0);

        }else{

            $categorie->setActive(1);

        }
       /* $json = $serializer->serialize($categorie, 'json', ['groups' => ['normal']]);*/
        $entityManager->persist($categorie);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$categorie->getActive(),
        ],200);

    }
}
  