<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\GroupeRepository;
use App\Services\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/siteweb", name="adminq", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {

        return $this->render('fils/_includes/index.html.twig');
    }

    
    /**
     * @Route("/admin/dashbord", name="admin", methods={"GET", "POST"})
     */
    public function  dashboard(PaginationService $paginationService):Response
    {
        $pagination = $paginationService->setEntityClass(Membre::class)->getData();
        return $this->render('admin/_includes/dashboard.html.twig', [
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
     * @Route("/home", name="home")
     */
    public function home(PaginationService $paginationService)
    {
        $pagination = $paginationService->setEntityClass(Membre::class)->getData();
        //Nom des colonnes en première lignes
        // le \n à la fin permets de faire un saut de ligne, super important en CSV
        // le point virgule sépare les données en colonnes
        $myVariableCSV = "Nom; Prenom;; Age;\n";
        //Ajout de données (avec le . devant pour ajouter les données à la variable existante)

        foreach ($pagination as $item){
        $myVariableCSV .= $item->getId().";".$item->getNom().";".$item->getPrenoms().";\n";
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
        );}
}
