<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    public function findByRole($role){ // permet d'afficher uniquement les users membre dans le filtre de l'accueil 
        $resultat = $this->createQueryBuilder("m")
                            ->where("m.roles LIKE '%" . $role . "%' ")
                            ->getQuery()->getResult();
            return $resultat;
    }


    public function findTopMembreNotes(){
        $entityManager = $this->getEntityManager(); // requerte pour recuperer la note moyenn du top 5 des membres 
        $requeteSQL = "SELECT m.id, m.pseudo, AVG(n.note) moyenne
                        FROM" . User::class . "m JOIN" . Note::class . " n " .
                        "GROUP by m.id
                        GROUP BY moyenne DESC"
                        ;
        $requete = $entityManager->createQuery($requeteSQL);
        return $requete->getResult();
    }


    public function findTop5MembreNotes(){
        $resultat = $this->createQueryBuilder("m")
                         ->join("n.membre_note", "n")
                         ->getQuery()->getResultat();       
    }





    // public function findAnnonceMembre()
    // {
    //     return $this->createQueryBuilder('a')
    //         ->select('a.annonce')
    //         ->andWhere('a.e = :val')
    //         ->distinct(true)
    //         ->orderBy("a.ville", 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
