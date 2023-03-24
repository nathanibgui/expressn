<?php

namespace App\Repository;

use App\Entity\Realisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Realisation>
 *
 * @method Realisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Realisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Realisation[]    findAll()
 * @method Realisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realisation::class);
    }

    public function save(Realisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Realisation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //fonction permettant d'avoir nom des regions a la place des ID
    public function findRealisation()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            dql: 'SELECT r, c.nom, cat.nom as Categorie
             FROM App\Entity\Realisation AS r, App\Entity\Client AS c, App\Entity\Categorie AS cat
             WHERE r.id_client = c.id and r.categorie = cat.id'
        );


        return $query->getResult();
    }


    public function anneeActuel()
    {
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'SELECT SUM(prix) FROM `realisation` where year(date) = year(NOW());';


        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();

    }

     public function moisActuel()
    {
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'SELECT SUM(prix) FROM `realisation` where year(date) = year(NOW()) and month(date) = month(NOW());';

        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();

    }

    public function jourActuel()
    {
        $entityManager = $this->getEntityManager()->getConnection();

        $query = 'SELECT SUM(prix) FROM `realisation` where year(date) = year(NOW()) and month(date) = month(NOW()) and day(date) = day(NOW());';

        $stmt = $entityManager->prepare($query);
        $rest = $stmt->executeQuery();

        return $rest->fetchAllAssociative();

    }

//    /**
//     * @return Realisation[] Returns an array of Realisation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Realisation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
