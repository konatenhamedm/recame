<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Membre;
use App\Entity\Profession;
use App\Form\MembreType;
use App\Form\SearchType;
use App\Repository\DepartementRepository;
use App\Repository\MembreRepository;
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
class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(PaginationService $paginationService, Request $request, MembreRepository $repository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $repository->findLastChrono($form->get('village')->getViewData()[0]);

        if($form->get('type')->getViewData() == "PDF")
        {

            $html = $this->renderView('admin/membre/test.html.twig', [
                'data' => $data
            ]);


            //}
            $mpdf = new \Mpdf\Mpdf([

                'mode' => 'utf-8', 'format' => 'A4'
            ]);
            $mpdf->PageNumSubstitutions[] = [
                'from' => 1,
                'reset' => 0,
                'type' => 'I',
                'suppress' => 'on'
            ];

            $mpdf->WriteHTML($html);
            $mpdf->SetFontSize(6);
            $mpdf->Output();
        }else{

            $myVariableCSV = "Nom ; Prenom ; Contacts ; Email ; Departement ; Village ; Sexe ; Profession\n";
            //Ajout de données (avec le . devant pour ajouter les données à la variable existante)

            foreach ($data as $item) {
             //  dd(  $item);
                $myVariableCSV .= $item['nom'] . ";" . $item['prenoms'] . ";" . $item['contacts'] . ";" . $item['email'] . ";" . $item['libelle'] . ";" . $item['libDepartement']. ";" . $item['sexe']. ";" . $item['profession'] .";\n";
            }

            //Si l'on souhaite ajouter un espace
            //$myVariableCSV .= " ; ; ; \n";
            //Autre donnée
            ///  $myVariableCSV .= "Chuck; Norris; 80;\n";
            //On donne la variable en string à la response, nous définissons le code HTTP à 200
            return new Response(
                $myVariableCSV,
                200,
                [
                    //Définit le contenu de la requête en tant que fichier Excel
                    'Content-Type' => 'application/vnd.ms-excel',
                    //On indique que le fichier sera en attachment donc ouverture de boite de téléchargement ainsi que le nom du fichier
                    "Content-disposition" => "attachment; filename=Tutoriel.csv"
                ]
            );
        }

        }
     //dd();



            // dd( $data);
            // }


        $pagination = $paginationService->setEntityClass(Membre::class)->getData();

        return $this->render('admin/membre/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'tableau' => [
                'photo' => 'photo',
                'Nom' => 'Nom',
                'Prenom' => 'Prenom',
                'Departement' => 'Departement',
                'Email' => 'Email',
                'contact' => 'contact'
            ],
            'critereTitre' => 'VILLAGES',
            'modal' => '',
            'position' => 4,
            'active' => 7,
            'titre' => 'LISTE DES MEMBRES',

        ]);
    }

    /**
     * @Route("/membre/{id}/show", name="membre_show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        $form = $this->createForm(MembreType::class, $membre, [
            'method' => 'POST',
            'action' => $this->generateUrl('membre_show', [
                'id' => $membre->getId(),
            ])
        ]);

        return $this->render('admin/membre/voir.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/membre/new", name="membre_new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @param MembreRepository $repository
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $em, UploaderHelper $uploaderHelper, MembreRepository $repository): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre, [
            'method' => 'POST',
            'action' => $this->generateUrl('membre_new')
        ]);

        $numero = 'RCM-' . $repository->getNombre();

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {
            $response = [];
            $statut = 1;
            $redirect = $this->generateUrl('membre');

            if ($form->isValid()) {

                $uploadedFile = $form['photo']->getData();
//dd($uploadedFile);
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadImage($uploadedFile);
                    $membre->setPhoto($newFilename);
                }
                $membre->setActive(1);
                $membre->setNumero($numero);
                $em->persist($membre);
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

        return $this->render('admin/membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/membre/{id}/edit", name="membre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Membre $membre, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(MembreType::class, $membre, [
            'method' => 'POST',
            'action' => $this->generateUrl('membre_edit', [
                'id' => $membre->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if ($form->isSubmitted()) {

            $response = [];
            $redirect = $this->generateUrl('membre');

            if ($form->isValid()) {
                $em->persist($membre);
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

        return $this->render('admin/membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/membre/delete/{id}", name="membre_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em, Membre $membre): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'membre_delete'
                    , [
                        'id' => $membre->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($membre);
            $em->flush();

            $redirect = $this->generateUrl('membre');

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
        return $this->render('admin/membre/delete.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_tarife", name="liste_tarife_index", methods={"GET","POST"})
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
     * @Route("/liste_membre/{mot}", name="imprimer", methods={"GET","POST"})
     * @param $mot
     * @param Request $request
     * @param MembreRepository $repository
     * @throws \Mpdf\MpdfException
     */
    public function imprime($mot, Request $request, MembreRepository $repository)
    {


        /*if($request->isXmlHttpRequest())
        { // pour vérifier la présence d'une requete Ajax*/

        /* $id = "";
         $id = $request->get('id');*/
        dd($repository->findLastChrono('village1'));
        //if ($id) {

        $data = $repository->findAll();
        // dd( $data);
        // }

        $html = $this->renderView('admin/membre/test.html.twig', [
            'data' => $data
        ]);


        //}
        $mpdf = new \Mpdf\Mpdf([

            'mode' => 'utf-8', 'format' => 'A4'
        ]);
        $mpdf->PageNumSubstitutions[] = [
            'from' => 1,
            'reset' => 0,
            'type' => 'I',
            'suppress' => 'on'
        ];

        $mpdf->WriteHTML($html);
        $mpdf->SetFontSize(6);
        $mpdf->Output();


    }

    /**
     * @Route("/fiche/{id}", name="fiche", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param Membre $membre
     * @param MembreRepository $membreRepository
     * @throws \Mpdf\MpdfException
     */
    public function imprimer($id, Request $request, MembreRepository $membreRepository)
    {

//dd($membreRepository->find($id));

        $html = $this->renderView('admin/membre/imprime.html.twig', [

            'client' => $membreRepository->find($id),
        ]);


        //}
        $mpdf = new \Mpdf\Mpdf([

            'mode' => 'utf-8', 'format' => 'A4'
        ]);
        $mpdf->PageNumSubstitutions[] = [
            'from' => 1,
            'reset' => 0,
            'type' => 'I',
            'suppress' => 'on'
        ];

        $mpdf->WriteHTML($html);
        $mpdf->SetFontSize(6);
        $mpdf->Output();


    }

    /**
     * @Route("/membre/{id}/active", name="membre_active", methods={"GET"})
     */
    public function active($id, Membre $parent, SerializerInterface $serializer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


        if ($parent->getActive() == 1) {

            $parent->setActive(0);

        } else {

            $parent->setActive(1);

        }
        $json = $serializer->serialize($parent, 'json', ['groups' => ['normal']]);
        $entityManager->persist($parent);
        $entityManager->flush();
        return $this->json([
            'code' => 200,
            'message' => 'ça marche bien',
            'active' => $parent->getActive(),
        ], 200);

    }
}
  