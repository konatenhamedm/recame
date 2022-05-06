<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Membre;
use App\Form\SearchType;
use App\Repository\CalendarRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MembreRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ProduitRepository;
use App\Services\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/calendar",name="calendrier")
     * @param CalendarRepository $repository
     * @return Response
     */
    public function calendar(CalendarRepository $repository,NormalizerInterface $normalizer)
    {
      $ligne = $repository->findAll();
      $rdvs = [];

      foreach ($ligne as $data){
          $rdvs [] = [
              'id'=>$data->getId(),
              'start'=>$data->getStart()->format('Y-m-d H:i:s'),
              'end'=>$data->getEnd()->format('Y-m-d H:i:s'),
              'description'=>$data->getDescription(),
              'title'=>$data->getTitle(),
              'allDay'=>$data->getAllDay(),
              'backgroundColor'=>$data->getBackgroundColor(),
              'borderColor'=>$data->getBorderColor(),
              'textColor'=>$data->getTextColor(),
          ];
      }

      $data =  json_encode($rdvs);
      //dd($data);

        return $this->render("calendar/calendar.html.twig",compact('data'));
    }
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     * @param Request $request
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function index(Request $request, CategorieRepository $categorieRepository)
    {
        $strs = str_replace(' ', '_', "cat 2");
       // dd($strs);
        $data = $categorieRepository->listeCategorie();
/*dd( $data);*/
        return $this->render('fils/home.html.twig', [
            'pagination' => $data
        ]);
    }

    /**
     * @Route("/about", name="about", methods={"GET", "POST"})
     * @param PartenaireRepository $partenaireRepository
     * @return Response
     */
    public function about(PartenaireRepository $partenaireRepository)
    {
        return $this->render('fils/about.html.twig',[
            'listePartenaires'=>$partenaireRepository->findAll()
        ]);
    }
    /**
     * @param $id
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function afficheProduitCategorie($id, ProduitRepository $produitRepository): Response
    {
        $data = $produitRepository->affiche_produit_all($id);


        return $this->render('fils/affiche_produit_dune_categorie.html.twig', [
            'data' => $data
        ]);
    }

    /**
     * @Route("/affiche_produit/{id}", name="one_produit", methods={"GET", "POST"})
     * @param $id
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function afficheProduit($id, ProduitRepository $produitRepository): Response
    {
        $data = $produitRepository->find($id);
//dd($data);

        return $this->render('fils/affiche_un_produit.html.twig', [
            'data' => $data
        ]);
    }


    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {


        return $this->render('fils/contact.html.twig', [

        ]);
    }


    /**
     * @Route("/admin/dashbord", name="admin", methods={"GET", "POST"})
     * @param PaginationService $paginationService
     * @param Request $request
     * @param MembreRepository $repository
     * @return Response
     */
    public function dashboard(PaginationService $paginationService, Request $request, MembreRepository $repository): Response
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

        $pagination = $paginationService->setEntityClass(Membre::class)->getData();
        return $this->render('admin/_includes/dashboard.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'tableau' => [
                'photo' => 'photo',
                'Nom' => 'Nom',
                'Prenom' => 'Prenom',
                'Village' => 'Village',
                'Email' => 'Email',
                'Departement' => 'Departement'
            ],
            'critereTitre' => 'VILLAGES',
            'modal' => '',
            'position' => 4,
            'active' => 7,
            'titre' => 'Liste des membres',

        ]);
    }

    /**
     * @Route("/home", name="home1")
     */
    public function home(PaginationService $paginationService)
    {
        $pagination = $paginationService->setEntityClass(Membre::class)->getData();
        //Nom des colonnes en première lignes
        // le \n à la fin permets de faire un saut de ligne, super important en CSV
        // le point virgule sépare les données en colonnes
        $myVariableCSV = "Nom; Prenom;; Age;\n";
        //Ajout de données (avec le . devant pour ajouter les données à la variable existante)

        foreach ($pagination as $item) {
            $myVariableCSV .= $item->getId() . ";" . $item->getNom() . ";" . $item->getPrenoms() . ";\n";
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
