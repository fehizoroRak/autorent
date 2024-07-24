<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

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
}

