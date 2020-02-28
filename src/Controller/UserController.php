<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository as UR;
use App\Repository\AnnonceRepository as AR;
use App\Form\AnnonceType;
use App\Form\UserType;
use App\Entity\Photo, Datetime;


class UserController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
    */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }



    /**
    * @Route("/profil", name="profil")
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
    public function profil(){
        $mes_annonces = $this->getUser()->getAnnonces();
        return $this->render("user/profil.html.twig", ["mes_annonces" => $mes_annonces]);
        
        
            
        
    }


    // /**
    // * @Route("/users", name="users")
    // */
    // public function showUser(User $user)
    // {
    //     $user = $user->findAll();
    //     return $this->render('user/list.html.twig', compact("user"));
    // }






    /**
    * @Route("/membre_add", name="membre_form", methods="get")
    */
    public function form()
    {
        $form = $this->createForm(UserType::class);
        return $this->render('user/adduser.html.twig', ['form' => $form->createView() ]);
    }



    /**
    * @Route("/membre_add", name="membre_add", methods="POST")
    */
    public function adde(Request $rq, EntityManagerInterface $em){
       
        $form = $this->createForm(UserType::class);
        $form->handleRequest($rq);
        if( $form->isSubmitted()) {
            if ($form->isValid() ){
            // recuperer les données envoyées (si le formulaire est lié à une entité, getData() renvoi un objet de la classe de cette entité)
            $data = $form->getData();
            // $user = new User();
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'utilisateur is Created!');
            return $this->redirectToRoute("home");

            }
            else {
                $this->addflash('error', 'les données du formulaire ne sont pas valide');
                // $form = $this->createForm(CategorieType::class, $form->getData());
    
            }
        }
        return $this->render('user/adduser.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    

    /**
     * @Route("/profil/annonces/ajouter", name="nouvelle_annonce")
     */
    public function nouvelle_annonce(Request $rq, EntityManagerInterface $em){
        $form = $this->createForm(AnnonceType::class);
        $form->handleRequest($rq);

        if($form->isSubmitted()){
            if($form->isValid()){
                $nvlAnnonce = $form->getData();
                $album = new Photo;
                $destination = $this->getParameter("dossier_images_annonces");
                for($i=1; $i<=5; $i++){
                    $champ = "photo" . $i;
                    if($photoUploadee = $form[$champ]->getData()){
                    $nomPhoto = pathinfo($photoUploadee->getClientOriginalName(), PATHINFO_FILENAME);
                    $nouveauNom = trim($nomPhoto);
                    $nouveauNom = str_replace(" ", "_", $nouveauNom);
                    $nouveauNom .= "-" . uniqid() . "." . $photoUploadee->guessExtension();
                    $photoUploadee->move($destination, $nouveauNom); 
                    $setter = "setPhoto$i";
                    $album->$setter($nouveauNom);
                    }
                }
                $em->persist($album);
                $em->flush();
                $nvlAnnonce->setDateEnregistrement(new DateTime());
                $nvlAnnonce->setPhoto($album);
                $nvlAnnonce->setUser($this->getUser());
                $em->persist($nvlAnnonce);
                $em->flush();
                $this->addFlash("success", "Votre annonce a bien été enregistrée");
                return $this->redirectToRoute("profil");

            }
            else{
                $this->addFlash("error", "Votre annonce n'a pas été enregistrée");
            }
        }

        $form = $form->createView();
        return $this->render("user/annonce.html.twig", compact("form"));
            
    }




    
    /**
     * @Route("/profil/annonces/modifier", name="update_annonce")
     */
    public function update_annonce(Request $rq, EntityManagerInterface $em, int $id, AR $ar){
        $annonceAmodifier = $ar->find($id);
        if($annonceAmodifier->getUser()->getId() == $this->getUser()->getId()){

            $form = $this->createForm(AnnonceType::class, $annonceAmodifier);
            $form->handleRequest($rq);

            if($form->isSubmitted()){
                if($form->isValid()){
                    $destination = $this->getParameter("dossier_images_annonces");
                    for($i=1; $i<=5; $i++){
                        $champ = "photo" . $i;
                        if($photoUploadee = $form[$champ]->getData()){
                            $nomPhoto = pathinfo($photoUploadee->getClientOriginalName(), PATHINFO_FILENAME);
                            $nouveauNom = trim($nomPhoto);
                            $nouveauNom = str_replace(" ", "_", $nouveauNom);
                            $nouveauNom .= "-" . uniqid() . "." . $photoUploadee->guessExtension();
                            $photoUploadee->move($destination, $nouveauNom); 
                            $setter = "setPhoto$i";
                            $annonceAmodifier->getPhoto()->$setter($nouveauNom);
                        }
                    }
                    $em->persist($annonceAmodifier);
                    $em->flush();
                    $this->addFlash("success", "Votre annonce a bien été modifié");
                    return $this->redirectToRoute("profil");

                }
                else{
                    $this->addFlash("error", "Il manque des informations pour modifier votre annonce");
                }
            }

            $form = $form->createView();
            return $this->render("user/annonce.html.twig", compact("form"));
        }
        else{
            $this->addFlash("error", "vous ne pouvez pas accedez a cet url" );
            return $this->rediretToroute("profil");
        }    
            
    }


    
      
    
}


