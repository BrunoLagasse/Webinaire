<?php

namespace App\Repository;


use App\Entity\Demande;
use App\Entity\Demandeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

/**
 * @method Demandeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demandeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demandeur[]    findAll()
 * @method Demandeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandeur::class);
    }

    // public function getUserByEmail(): array
    // {
    //     return $this->createQueryBuilder('d')
    //         ->leftJoin('d.demandes', 'e')
    //         ->addSelect('e')
    //         ->getQuery()->getResult();
    // }

    // public function getDemandeurByEmail($id){
    //     $demandeur = $this->getDoctrine()
    //                 ->getRepository('Demandeur')
    //                 ->findByEmail('email');
    // }

    // public function findExistingEmail()
    // {
    //      return $this->getEntityManager()
    //              ->createQuery('SELECT d FROM Demandeur:Email d ORDER BY d.date ASC')->getResult();
    // }

    // public function nom()
    // {
    //     $queryBuilder = $this->createQueryBuilder("d")
    //             ->select('d.id')
    //             ->from('demandeur')
    //             ->where('email = ?')
    //         ;
    //         return $queryBuilder->getQuery()->getResult();
    // }

    // public function nom(string $email)
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT d.id
    //         FROM App\Entity\Demandeur d
    //         WHERE d.email = :email'
    //     )->setParameter('email', $email);

    //     // returns an array of Product objects
    //     return $query->getResult();
    // }


    // public function findEmail($email)
    // {
    //     $email = "$email";
    //     return $this->createQueryBuilder('d')
    //         ->andWhere('d.email = :email')
    //         ->setParameter('email', $email)
    //         ->orderBy('d.id', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function getId($email) {
    //     $query = $this->createQueryBuilder('d')
    //                   ->where('d.email > 1')
    //                   ->setParameter('email', $email)
    //                   ->getQuery();
                    
    //     return $query->getResult();
    // }

    // public function findDemandeurId() {
    //     return $this->createQueryBuilder('d') // d pour "demandeur"
    //         ->andWhere('d.email = :email') // on défini le paramètre de requête
    //         ->setParameter('email', 'd') // on défini le paramètre dynamique
    //         ->orderBy('d.lastname', 'ASC') // On défini ici l'ordre de tri
    //         ->setMaxResults(10) // Récupération de 10 élément maximum
    //         ->getQuery() // Récupération de la query
    //         ->getResult() // Récupération du résultat de la query
    //         ;
    // }


    // /**
    //  * @return Demandeur[] Returns an array of Demandeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Demandeur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllObjRelativeToDemandeur(Demandeur $demandeur)
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin('d.demandes', 'de')
            ->where('d.person_asking = :demandeur')
            ->orWhere('de = :demandeur')
            ->setParameter('demandeur', $demandeur);

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
