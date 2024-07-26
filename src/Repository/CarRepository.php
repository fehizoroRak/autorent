<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findAvailableCars(\DateTime $startDate, \DateTime $endDate, string $pickupLocation, string $dropoffLocation): array
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.locations', 'l')
            ->where('c.availability = :available')
            ->andWhere('l.startdate IS NULL OR l.enddate < :startDate OR l.startdate > :endDate')
            ->setParameter('available', true)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate);

        return $qb->getQuery()->getResult();
    }

        /**
     * Get recommended cars
     *
     * @return Car[]
     */
    public function findRecommendedCars(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.isRecommended = true')
            ->setMaxResults(5) // Limiter à 5 voitures recommandées
            ->orderBy('c.id', 'DESC') // Par exemple, les dernières voitures ajoutées
            ->getQuery()
            ->getResult();
    }
}

