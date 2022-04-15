<?php

namespace App\Controller;

use App\Entity\CodeDepartement;
use App\Entity\Departement;
use App\Entity\Localite;
use App\Entity\Membre;
use App\Entity\ModuleParent;
use App\Entity\Profession;
use App\Form\MembreType;
use App\Repository\DepartementRepository;
use App\Repository\LocaliteRepository;
use App\Repository\MembreRepository;
use App\Services\PaginationService;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvents;


/**
 * @Route("/admin")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(PaginationService $paginationService): Response
    {
        $pagination = $paginationService->setEntityClass(Membre::class)->getData();

        return $this->render('admin/membre/index.html.twig', [
            'pagination' => $pagination,
            'tableau' => [
                'photo'=> 'photo',
                'Nom'=> 'Nom',
                'Prenom'=> 'Prenom',
                'Departement'=> 'Departement',
                'Email'=> 'Email',
                'region'=>'region'
            ],
            'critereTitre'=>'Departements',
            'modal' => '',
            'position' => 4,
            'active'=> 7,
            'titre' => 'Liste des membres',

        ]);
    }
    /**
     * @Route("/membre/{id}/show", name="membre_show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        $form = $this->createForm(MembreType::class,$membre, [
            'method' => 'POST',
            'action' => $this->generateUrl('membre_show',[
                'id'=>$membre->getId(),
            ])
        ]);

        return $this->render('admin/membre/voir.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/membre/new", name="membre_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface  $em,UploaderHelper  $uploaderHelper,MembreRepository $repository): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class,$membre ,[
            'method' => 'POST',
            'action' => $this->generateUrl('membre_new')
        ]);

        $numero = 'RCM-'.$repository->getNombre();

        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {
            $response = [];
            $statut = 1;
            $redirect = $this->generateUrl('membre');

            if($form->isValid()){

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

        return $this->render('admin/membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/membre/{id}/edit", name="membre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Membre $membre, EntityManagerInterface  $em): Response
    {

        $form = $this->createForm(MembreType::class,$membre, [
            'method' => 'POST',
            'action' => $this->generateUrl('membre_edit',[
                'id'=>$membre->getId(),
            ])
        ]);
        $form->handleRequest($request);

        $isAjax = $request->isXmlHttpRequest();

        if($form->isSubmitted())
        {

            $response = [];
            $redirect = $this->generateUrl('membre');

            if($form->isValid()){
                $em->persist($membre);
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

        return $this->render('admin/membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/membre/delete/{id}", name="membre_delete", methods={"POST","GET","DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $em,Membre $membre): Response
    {


        $form = $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'membre_delete'
                    ,   [
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
        return $this->render('admin/membre/delete.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste_tarife", name="liste_tarife_index", methods={"GET","POST"})
     */
    public function remplirSelect2Action(Request $request,DepartementRepository $repository,EntityManagerInterface  $em):Response
    {
        $response = new Response();
        if($request->isXmlHttpRequest())
        { // pour vérifier la présence d'une requete Ajax

            $id = "";
            $id = $request->get('id');

            if ($id) {

                $ensembles = $repository->listeDepartement($id);

                $arrayCollection = array();

                foreach($ensembles as $item) {
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
     * @Route("/liste_membre", name="imprimer", methods={"GET","POST"})
     */
    public function imprime(Request $request,MembreRepository $repository)
    {


        /*if($request->isXmlHttpRequest())
        { // pour vérifier la présence d'une requete Ajax*/

           /* $id = "";
            $id = $request->get('id');*/

            //if ($id) {

                $data = $repository->findAll();
       // dd( $data);
           // }

            $html = $this->renderView('admin/membre/test.html.twig',[
                'data'=>$data
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
     * @Route("/fiche/{id}", name="imprimer", methods={"GET","POST"})
     */
    public function imprimer($id,Request $request,MembreRepository $repository)
    {


        /*if($request->isXmlHttpRequest())
        { // pour vérifier la présence d'une requete Ajax*/

        /* $id = "";
         $id = $request->get('id');*/

        //if ($id) {

        $data = $repository->find($id);
        // dd( $data);
        // }

        $html = $this->renderView('admin/membre/test.html.twig',[
            'data'=>$data
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
    public function active($id,Membre $parent, SerializerInterface $serializer): Response
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
  