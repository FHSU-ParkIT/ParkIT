<?php

namespace App\Repository;

use App\Entity\ParkingSpot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParkingSpot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingSpot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingSpot[]    findAll()
 * @method ParkingSpot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingSpotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingSpot::class);
    }

    // /**
    //  * @return ParkingSpot[] Returns an array of ParkingSpot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParkingSpot
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
