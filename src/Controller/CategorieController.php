<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository as CR;

use App\Entity\Categorie;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CR $repo)
    {
        $categories = $cat->findAll();
        return $this->render('categorie/table.html.twig', compact("categories"));
    }


    /**
     * @Route("/add", name="categorie_form", methods="GET")
    */
    public function addcat()
    {
        $form = $this->createForm(CategorieType::class);
        return $this->render('categorie/index.html.twig',['form' => $form->createView()]);
    }

    /**
    * @Route("/add", name="add_cat")
    */
    public function adde(Request $rq, EntityManagerInterface $em){
       
        $form = $this->createForm(CategorieType::class);
        $form->handleRequest($rq);
        if( $form->isSubmitted()) {
            if ($form->isValid() ){
            // recuperer les données envoyées (si le formulaire est lié à une entité, getData() renvoi un objet de la classe de cette entité)
            $data = $form->getData();
            $categories = new Categorie();
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'Categorie is Created!');
            return $this->redirectToRoute("home");

            }
            else {
                $this->addflash('error', 'les données du formulaire ne sont pas valide');
                // $form = $this->createForm(CategorieType::class, $form->getData());
    
            }
        }
        return $this->render('categorie/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
