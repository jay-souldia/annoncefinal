<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @param id_user : integer
     * @return float | null
     */
    public function noteMoyenneRecue(int $id_user){
        $requete = $this->createQueryBuilder("n")
                        ->select("AVG(n.note)")
                        ->join("n.usernote", "u")
                        ->where("u.id = :id")
                        ->groupBy("u.id")
                        ->setParameter("id", $id_user)
                        ->getQuery()
                        ->getResult();

        return !empty($requete) ? $requete[0][1] : null; // je verifie si il ya une note sinon je renvoi null
        
        
        /*
        SELECT AVG(n.note) //  en sql 
        FROM note n JOIN membre m ON n.membre_note_id = m.id
        WHERE m.id = $id_membre
        GROUP BY m.id
        */
    }


    public function findTop5MembreNotes(){
        $resultat = $this->createQueryBuilder("n") // top 5 des membres les mieux notés 
                        ->select("u.id, u.pseudo, AVG(n.note) moyenne, COUNT(u.id) nb")
                         ->join("n.usernote", "u")
                         ->groupBy("u.id")
                         ->orderBy("moyenne", "DESC")
                         ->setMaxResultats(5)
                         ->getQuery()->getResultat();       
    }






    // /**
    //  * @return Note[] Returns an array of Note objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Note
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
