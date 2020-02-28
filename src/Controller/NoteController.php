<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository as UR;
use Doctrine\ORM\EntityManagerInterface as EMI;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AttribuerNoteType;

class NoteController extends AbstractController
{
    /**
     * @Route("/note", name="note")
     */
    public function index()
    {
        return $this->render('note/index.html.twig', [
            'controller_name' => 'NoteController',
        ]);
    }

    /**
     * @Route("/profil/attribuer_note/{pseudo}", name="attribuer_note")
     */
    public function attribuer(UR $mr, Request $rq, EMI $em, $pseudo){
        if($pseudo == $this->getUser()->getPseudo()){
            $this->addFlash("error", "Vous ne pouvez pas vous noter vous-même, petit salopiaud !");
            return $this->redirectToRoute("profil");
        }

        $user = $mr->findOneBy([ "pseudo" => $pseudo ]);

        $form = $this->createForm(AttribuerNoteType::class);
        $form->handleRequest($rq);
        if($form->isSubmitted()){
            if($form->isValid()){
                $note = $form->getData();
                $note->setUserNotant($this->getUser());
                $note->setDateEnregistrement(new \DateTime());
                $note->setUserNote($user);
                $em->persist($note);
                $em->flush();
                $this->addFlash("success", "Votre note a bien été prise en compte");
                return $this->redirectToRoute("profil");
            }
            else{
                $this->addFlash("error", "Une erreur est survenu !");
            }
        }

        $form = $form->createView();
        return $this->render("note/attribuer.html.twig", compact("membre", "form"));
    }
}
