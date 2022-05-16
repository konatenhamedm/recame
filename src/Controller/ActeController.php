<?php

namespace App\Controller;

use App\Entity\Acte;
use App\Form\ActeType;
use App\Repository\ActeRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class ActeController extends AbstractController
{
    /**
     * @Route("/acte", name="acte")
     * @param ActeRepository $repository
     * @return Response
     */
    public function index(PaginationService $paginationService): Response
    {

        $pagination = $paginationService->setEntityClass(Acte::class)->getData();
        //dd($pagination);
        return $this->render('admin/acte/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'numero' => 'numero',
                'Date' => 'Date',
                'Objet' => 'Objet',
                'Vendeur' => 'Vendeur',
                'Acheteur' => 'Acheteur',
                'Montant' => 'Montant'
            ],
            'critereTitre' => '',
            'modal' => 'modal',
            'position' => 4,
            'active' => 7,
            'titre' => 'Liste des acte',

        ]);
    }

    /**
     * @Route("/acte/{id}/show", name="acte_show", methods={"GET"})
     * @param Acte $acte
     * @return Response
     */
    public function show(acte $acte): Response
    {
        $type = $acte->getType();

        $form = $this->createForm(ActeType::class, $acte, [

            'method' => 'POST',
            'action' => $this->generateUrl('acte_show', [
                'id' => $acte->getId(),
            ])
        ]);

        return $this->render('admin/acte/voir.html.twig', [
            'titre'=>'ACTE',
            'acte' => $acte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acte/new", name="acte_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param ActeRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper,ActeRepository $repository): Response
    {
        $acte = new acte();
        $form = $this->createForm(ActeType::class, $acte, [
            'method' => 'POST',
            'action' => $this->generateUrl('acte_new')
        ]);


        $form->handleRequest($request);


        $isAjax = $request->isXmlHttpRequest();
       $type = $form->getData()->getType();
        if ($form->isSubmitted()) {
            $statut = 1;
            $redirect = $this->generateUrl('acte');
            $brochureFile = $form->get('fichiers')->getData();

        //    dd($brochureFile);
            if ($form->isValid()) {
                $nombre = $repository->getNombre();
                $type = $request->get('type');
                $date = date('y');

                    $format = $date.'-'.$nombre.' '.'ACTE';

                foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $acte->setNumero($format);
                $acte->setActive(1);
                $em->persist($acte);
                $em->flush();

                $message = 'Opération effectuée avec succès';

                $this->addFlash('success', $message);

            }
            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/acte/new.html.twig', [
            'titre'=>'ACTE',
            'acte' => $acte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acte/{id}/edit", name="acte_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Acte $acte
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function edit(Request $request,Acte $acte, EntityManagerInterface $em): Response
    {


        $form = $this->createForm(ActeType::class, $acte, [
            'method' => 'POST',
            'action' => $this->generateUrl('acte_edit', [
                'id' => $acte->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();
        $type = $form->getData()->getType();
        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('acte');
            $brochureFile = $form->get('fichiers')->getData();

            if ($form->isValid()) {

               foreach ($brochureFile as $image) {
                    $file = new File($image->getPath());
                    $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                    // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('images_directory'), $newFilename);
                    $image->setPath($newFilename);
                }
                $em->persist($acte);
                $em->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $this->addFlash('success', $message);

            }

            if ($isAjax) {
                return $this->json(compact('statut', 'message', 'redirect'));
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/acte/edit.html.twig', [
            'titre'=>'ACTE',
            'acte' => $acte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/acte/delete/{id}", name="acte_delete", methods={"POST","GET","DELETE"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Acte $acte
     * @return Response
     */
    public function delete(Request $request, EntityManagerInterface $em,Acte $acte): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'acte_delete'
                    , [
                        'id' => $acte->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($acte);
            $em->flush();

            $redirect = $this->generateUrl('acte');

            $message = 'Opération effectuée avec succès';

            $response = [
                'statut' => 1,
                'message' => $message,
                'redirect' => $redirect,
            ];

            $this->addFlash('success', $message);

            if (!$request->isXmlHttpRequest()) {
                return $this->redirect($redirect);
            } else {
                return $this->json($response);
            }


        }
        return $this->render('admin/acte/delete.html.twig', [
            'acte' => $acte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_tarife", name="liste_tarife_index", methods={"GET","POST"})
     * @param Request $request
     * @param DepartementRepository $repository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function remplirSelect2Action(Request $request, DepartementRepository $repository, EntityManagerInterface $em): Response
    {
        $response = new Response();
        if ($request->isXmlHttpRequest()) { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = $request->get('id');

            if ($id) {

                $ensembles = $repository->listeDepartement($id);

                $arrayCollection = array();

                foreach ($ensembles as $item) {
                    $arrayCollection[] = array(
                        'id' => $item->getId(),
                        'libelle' => $item->getLibDepartement(),
                        // ... Same for each property you want
                    );
                }
                $data = json_encode($arrayCollection); // formater le résultat de la requête en json
                //dd($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);

            }

        }

        return $response;
    }

    /**
     * @Route("/acte/{id}/active", name="acte_active", methods={"GET"})
     * @param $id
     * @param Acte $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id,Acte $parent, EntityManagerInterface $entityManager): Response
    {

        if ($parent->getActive() == 1) {

            $parent->setActive(0);

        } else {

            $parent->setActive(1);

        }

        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'active' => $parent->getActive(),
        ], 200);

    }

    /**
     * @Route("/existe", name="exsite", methods={"GET","POST"})
     * @param ActeRepository $repository
     * @param Request $request
     * @return Response
     */
    public function existe(ActeRepository $repository,Request $request): Response
    {
        $response = new Response();
        if ($request->isXmlHttpRequest()) {
            $nombre = '$repository->getNombre()';
            $type = $request->get('type');
            $date = date('y');

                $format = $date.'-'.$nombre.' '.'I';

            $arrayCollection[] = array(
                'nom' =>  $format,

                // ... Same for each property you want
            );
            $data = json_encode($arrayCollection); // formater le résultat de la requête en json
            //dd($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($data);
        }
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'nom' => $format,
        ], 200);

    }
}
  