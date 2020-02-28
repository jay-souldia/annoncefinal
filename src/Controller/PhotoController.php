<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PhotoType;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends AbstractController
{
    /**
     * @Route("/photo", name="photo")
     */
    public function index()
    {
        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }
    /**
     * @Route("/photo_add", name="photo_form", methods="GET")
     */
    public function form()
    {
        $form = $this->createForm(PhotoType::class);
        return $this->render('photo/index.html.twig', [
            'form' => $form->createView()
        ]);

        
    }
    /**
     * @Route("/photo_add", name="photo_add", methods="POST")
     */
    public function add(Request $request, EntityManagerInterface $em, Session $session)
    {
            $photo = (new Photo)
                                        ->setPhoto1($request->request->get("photo")["photo1"])
                                        ->setPhoto2($request->request->get("photo")["photo2"] ?? "")
                                        ->setPhoto3($request->request->get("photo")["photo3"] ?? "")
                                        ->setPhoto4($request->request->get("photo")["photo4"] ?? "")
                                        ->setPhoto5($request->request->get("photo")["photo5"] ?? "");
            $em->persist($photo);
            $resultat = $em->flush();
            $message = "Les photos ont bien été enregistrées";
            $session->set("message", $message);
            return $this->redirectToRoute("home");
            
    }
}