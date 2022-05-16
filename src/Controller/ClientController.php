<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\DepartementRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     * @param PaginationService $paginationService
     * @return Response
     */
    public function index(PaginationService $paginationService): Response
    {

        $pagination = $paginationService->setEntityClass(Client::class)->getData();

        return $this->render('admin/client/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'photo' => 'photo',
                'Nom' => 'Nom',
                'Prenoms' => 'Prenoms',
                'email' => 'email',
                'profession' => 'profession',
            ],
            'critereTitre'=>'',
            'modal' => '',
            'position' => 4,
            'active'=> 3,
            'titre' => 'Liste des clients',

        ]);
    }

    /**
     * @Route("/client/{id}/show", name="client_show", methods={"GET"})
     * @param Client $client
     * @return Response
     */
    public function show(client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client, [
            'method' => 'POST',
            'action' => $this->generateUrl('client_show', [
                'id' => $client->getId(),
            ])
        ]);

        return $this->render('admin/client/voir.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/new", name="client_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param ClientRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client, [
            'method' => 'POST',
            'action' => $this->generateUrl('client_new')
        ]);

        //$numero = 'RCM-' . $repository->getNombre();

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {
            $statut = 1;
           // dd($form->getData());
            $redirect = $this->generateUrl('client');

            if ($form->isValid()) {

                $uploadedFile = $form['photo']->getData();

                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $client->setPhoto($newFilename);
                }
               $date = \DateTime::createFromFormat('d-m-Y', date("Y-m-d H:i:s"));
                $client->setFaitLe($date);
                $client->setActive(1);
                $em->persist($client);
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

        return $this->render('admin/client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/{id}/edit", name="client_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Client $client
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    public function edit(Request $request, Client $client, EntityManagerInterface $em, UploaderHelper $uploaderHelper): Response
    {

        $form = $this->createForm(ClientType::class, $client, [
            'method' => 'POST',
            'action' => $this->generateUrl('client_edit', [
                'id' => $client->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {

            $redirect = $this->generateUrl('client');

           // dd($uploadedFile);
            if ($form->isValid()) {

                $uploadedFile = $form['photo']->getData();
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $client->setPhoto($newFilename);
                }
                $em->persist($client);
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

        return $this->render('admin/client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/delete/{id}", name="client_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em, Client $client): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'client_delete'
                    , [
                        'id' => $client->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($client);
            $em->flush();

            $redirect = $this->generateUrl('client');

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
        return $this->render('admin/client/delete.html.twig', [
            'client' => $client,
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
     * @Route("/client/{id}/active", name="client_active", methods={"GET"})
     * @param $id
     * @param Client $parent
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function active($id, Client $parent, EntityManagerInterface $entityManager): Response
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
}
  