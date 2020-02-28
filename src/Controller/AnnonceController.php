<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NoteType;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Repository\UserRepository as UR;
use App\Repository\AnnonceRepository as AR;
use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Annonce;
use App\Entity\User;


class AnnonceController extends AbstractController
{


    /**
    * @Route("/afficher/annonce/{id}", name="annonce_afficher")
    */
    public function list(AR $ann, NoteRepository $nr, int $id){
        $annonce = $ann->find($id);
        $moyenne = $nr->noteMoyenneRecue($annonce->getUser()->getId());
        return $this->render("annonce/fiche.html.twig", compact("annonce", "moyenne"));
    }

    
    
    /**
    * @Route("/annonce/ajouter", name="annonce_add")
    */
    public function adde(Request $rq, EntityManagerInterface $em){
       
        $form = $this->createForm(AnnonceType::class);
        $form->handleRequest($rq);
        if( $form->isSubmitted()) {
            if ($form->isValid() ){
            // recuperer les données envoyées (si le formulaire est lié à une entité, getData() renvoi un objet de la classe de cette entité)
            $data = $form->getData();
            $data->setDateEnregistrement(date_create("now") );
            $file= $form['attachment']->getData();
            $file->move($directory, $someNewFilename);
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'Annonce is Created!');
            return $this->redirectToRoute("home");

            }
            else {
                $this->addflash('error', 'les données du formulaire ne sont pas valide');
                // $form = $this->createForm(CategorieType::class, $form->getData());
    
            }
        }
        return $this->render('annonce/formulaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }



   
}
