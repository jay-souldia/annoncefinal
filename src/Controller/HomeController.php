<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository as CR;
use App\Repository\AnnonceRepository as AR;
use App\Repository\UserRepository as UR;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{


    /**
    * @Route("/", name="home")
    */
    public function index(Request $req, AR $annRepo, CR $catRepo, UR $userRepo, Session $session)
    {
        $categorie_choisie = null;
        $user_choisi = null;
        $ville_choisie = null;
        $prix_choisi = 0;

        if($req->getMethod() == "POST"){ // sert a afficher les elements selectionné sur le filtre()
            
            $where = [];
            if($categorie_choisie = $req->request->get("categorie")){
                $where["categorie"] = $categorie_choisie;
            }

            if($user_choisi = $req->request->get("user")){
                $where["user"] = $user_choisi;
            }

            if($ville_choisie = $req->request->get("region")){
                $where["ville"] = $ville_choisie;
            }

            $annonces = $annRepo->findBy($where);
            if($prixChoisi = $req->request->get("prix")){// la fonction array_filter permet de filtrer les valeurs d'un array selon le resultat d'une fonction
                //(appélé callback)
                // cette fonction doit retoruner un booleen (si le retour vaut true, la valeur de l'array est gardée dans le resultat final)
                // Array_filter retourne un Array 
                $annonces = array_filter($annonces, function($ann) use($prix_choisi){
                    return $ann->getPrix() <= $prix_choisi;
                });
            }
            
        }
        else{
            $mot = $req->query->get("recherche"); // permet de faire une recherche de categorie dans la barre de recherche
            if($mot){
                $cats = $catRepo->recherche($mot);
                $annonces = [];
                foreach($cats as $cat){
                    foreach($cat->getAnnonces() as $annonceCategorie){
                        $annonce[] = $annonceCategorie;
                    }  
                }

            }else{
                $annonces = $annRepo->findAll();
            }
            
        }


        $categories = $catRepo->findAll();
        $users = $userRepo->findbyRole("ROLE_USER"); // appel uniquement les users membres dans le filtre de l'accueil 
        $regions = $annRepo->findVille();
        // $annonces = $annRepo->findAll();
        $message = $session->get("message");
        $session->set("message", "");
        return $this->render('home/index.html.twig', compact("categories", "users", "annonces", "regions", "message", "prix_choisi", "categorie_choisie", "user_choisi", "ville_choisie"));
        
    }
    
//     /**
//     * @Route("/lister_villes", name="lister_villes")
//     */
//    public function villes_list(AR $repo)
//    {
//        $liste = array_unique($repo->findAll()->getVille());
//        return $this->render("base.html.twig");
//    }
   
}
