<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }





    public function findVille()
    {
        return $this->createQueryBuilder('a')
            ->select('a.ville')
            ->distinct(true)
            ->orderBy("a.ville", 'ASC')
            ->getQuery()
            ->getResult()
        ;

        //  version avec EntityManager
        $entityManager = $this->getEntityManager();
        $requete = $entityManager->createQuery("SELECT DISTINCT a.ville FROM App\Entity\Annonce ORDER BY a.ville");
        return $requete->getResultat();
    }


    public function findTop5MembresActifs(){ // selectionné le Top 5 des membres les plus actifs 
        return $this->createQueryBuilder("a")
                    ->select("m.*, COUNT(*) nb")
                    ->join("a.membre", "m")
                    ->groupBy("m.id")
                    ->orderBy("nb", "DESC")
                    ->setMaxResults(5)
                    ->getQuery()
                    ->getResult();
    }

    public function findTopAnnoncesAnciennes(){
        return $this->createQueryBuilder("a")
                    ->orderBy("a.date_enregistrement", "ASC")
                    ->setMaxResults(5)
                    ->getQuery()->getResult();
    }


    public function findTop5CategoriesPlus(){
        return $this->createQueryBuilder("a")
                    ->select("c.id, COUNT(*) nb")
                    ->join("a.categorie", "c")
                    ->groupBy("c.id")
                    ->orderBy("nb", "DESC")
                    ->setMaxResults(5)
                    ->getQuery()->getResult();
    }






    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
