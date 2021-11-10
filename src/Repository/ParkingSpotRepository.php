<?php

namespace App\Repository;

use App\Entity\ParkingSpot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Error;

/**
 * @method ParkingSpot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingSpot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingSpot[]    findAll()
 * @method ParkingSpot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingSpotRepository extends ServiceEntityRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, ParkingSpot::class);
        $this->connection = $connection;
    }

    // Select a random ID within the Parking spot and check to see if there is a reservation between the proposed times:


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


    /**
     * @param $id
     * @return ParkingSpot|null
     * @throws Error
     */
    public function findOneById($id): ?ParkingSpot
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.id = :val')
                ->setParameter('val', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new Error('More than one result found. :^(');
        }
    }

    public function findRandomParkingSpotAndReturnId()
    {
        return $this->connection->fetchOne('select id from parking_spot order by RAND()');
    }
}
