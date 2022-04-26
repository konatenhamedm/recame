<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Chambre::class)->getData();

        return $this->render('admin/chambre/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'Image'=> 'Image',
                'libelle'=> 'libelle',
                'prix'=> 'prix',
            ],
            'critereTitre'=>'',
            'modal' => '',
            'position' => 4,
            'active'=> 4,
            'titre' => 'Liste des chambres',

        ]);
    }

    /**
     * @Route("/chambre/{id}/show", name="chambre_show", methods={"GET"})
     * @param Chambre $chambre
     * @return Response
     */
    public function show(Chambre $chambre): Response
    {
        $form = $this->createForm(ChambreType::class,$chambre, [
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_show',[
                'id'=>$chambre->getId(),
            ])
        ]);

        return $this->render('admin/chambre/voir.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/new", name="chambre_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper): Response
    {
        $chambre = new Chambre();

        $form = $this->createForm(chambreType::class,$chambre ,[
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_new')
        ]);

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $statut = 1;
            $redirect = $this->generateUrl('chambre');

            if($form->isValid()){

                $uploadedFile = $form['image']->getData();

                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $chambre->setImage($newFilename);
                }
                $brochureFile = $form->get('image')->getData();
             //   dd($form->getData());
                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $chambre->setActive(1);
                $em->persist($chambre);
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

        return $this->render('admin/chambre/new.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/{id}/edit", name="chambre_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Chambre $chambre
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function edit(Request $request,Chambre $chambre, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper): Response
    {

        $form = $this->createForm(chambreType::class,$chambre, [
            'method' => 'POST',
            'action' => $this->generateUrl('chambre_edit',[
                'id'=>$chambre->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $redirect = $this->generateUrl('chambre');

            if($form->isValid()){

                $uploadedFile = $form['image']->getData();

                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $chambre->setImage($newFilename);
                }
                $brochureFile = $form->get('image')->getData(); //get('image_prod')->getData();

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }

                $em->persist($chambre);
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

        return $this->render('admin/chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chambre/delete/{id}", name="chambre_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Chambre $chambre
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Chambre $chambre): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'chambre_delete'
                    ,   [
                        'id' => $chambre->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($chambre);
            $em->flush();

            $redirect = $this->generateUrl('chambre');

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
        return $this->render('admin/chambre/delete.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/chambre/{id}/active", name="chambre_active", methods={"GET"})
     * @param Chambre $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active(Chambre $parent, EntityManagerInterface $entityManager): Response
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
  