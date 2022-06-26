<?php

namespace App\Repository;

use App\Entity\ActivitiesSubmitted;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivitiesSubmitted|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivitiesSubmitted|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivitiesSubmitted[]    findAll()
 * @method ActivitiesSubmitted[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivitiesSubmittedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivitiesSubmitted::class);
    }

    // /**
    //  * @return ActivitiesSubmitted[] Returns an array of ActivitiesSubmitted objects
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
    public function findOneBySomeField($value): ?ActivitiesSubmitted
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
