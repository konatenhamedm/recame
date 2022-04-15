<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/admin")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Produit::class)->getData();

        return $this->render('admin/produit/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'libelle'=> 'libelle',
                'date'=> 'date',
                'description'=> 'description',
            ],
            'critereTitre'=>'',
            'modal' => '',
            'position' => 4,
            'active'=> 4,
            'titre' => 'Liste des produits',

        ]);
    }
    /**
     * @Route("/produit/{id}/show", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        $form = $this->createForm(produitType::class,$produit, [
            'method' => 'POST',
            'action' => $this->generateUrl('produit_show',[
                'id'=>$produit->getId(),
            ])
        ]);

        return $this->render('admin/produit/voir.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/produit/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper,ProduitRepository $repository): Response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class,$produit ,[
            'method' => 'POST',
            'action' => $this->generateUrl('produit_new')
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $statut = 1;
            $redirect = $this->generateUrl('produit');

            if($form->isValid()){

                $brochureFile = $form->get('image')->getData(); //get('image_prod')->getData();

                foreach ($brochureFile as $image) {
                    dd($image->getPath());
                    if ($image) {
                        $newFilename = $uploaderHelper->uploadImage($image->getPath());
                        $image->setPhoto($newFilename);
                    }
                   /* $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);*/
                }
                $produit->setActive(1);
                $em->persist($produit);
                $em->flush();

                $message       = 'Opération effectuée avec succès';

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

        return $this->render('admin/produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/{id}/edit", name="produit_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Produit $produit
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,Produit $produit, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(ProduitType::class,$produit, [
            'method' => 'POST',
            'action' => $this->generateUrl('produit_edit',[
                'id'=>$produit->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('produit');

            if($form->isValid()){

                $brochureFile = $form->get('image')->getData(); //get('image_prod')->getData();

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }

                $em->persist($produit);
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

        return $this->render('admin/produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/delete/{id}", name="produit_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Produit $produit
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Produit $produit): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'produit_delete'
                    ,   [
                        'id' => $produit->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($produit);
            $em->flush();

            $redirect = $this->generateUrl('produit');

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
        return $this->render('admin/produit/delete.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/produit/{id}/active", name="produit_active", methods={"GET"})
     * @param $id
     * @param Produit $parent
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Produit $parent, SerializerInterface $serializer,EntityManagerInterface $entityManager): Response
    {

        if ($parent->getActive() == 1){

            $parent->setActive(0);

        }else{

            $parent->setActive(1);

        }
       /* $json = $serializer->serialize($parent, 'json', ['groups' => ['normal']]);*/
        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'ça marche bien',
            'active'=>$parent->getActive(),
        ],200);

    }
}
  