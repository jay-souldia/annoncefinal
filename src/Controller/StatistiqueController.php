<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NoteRepository;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index(NoteRepository $nr)
    {
        $top5membres = $nr->findTop5MembresNotes();
        $top5mbrActif = $nr->findTop5MembresActifs();
        $top5AnnAncienne = $nr->findTop5AnnonceAnciennes();
        $top5Categorie = $nr->findTop5CategoriesPlus();
        dd($top5membres);
        return $this->render('statistique/index.html.twig', [

        ]);
    }
}
