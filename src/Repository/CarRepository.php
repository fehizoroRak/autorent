<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * Trouve les voitures disponibles en dehors des périodes où elles sont louées et pour les lieux spécifiés.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $pickupLocation
     * @param string $dropoffLocation
     * @param string|null $priceOrder
     * @param string|null $gearbox
     * @param int|null $doors
     * @return Car[]
     */
    public function findAvailableCarsWithFilters(
        \DateTime $startDate,
        \DateTime $endDate,
        string $pickupLocation,
        string $dropoffLocation,
        ?string $priceOrder,
        ?string $gearbox,
        ?int $doors,

    ): array {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.locations', 'l')
            ->where('l.id IS NULL OR (NOT EXISTS (
                SELECT 1 FROM App\Entity\Location loc
                WHERE loc.car = c
                AND loc.pickupLocation = :pickupLocation
                AND loc.dropoffLocation = :dropoffLocation
                AND (
                    (:startDate BETWEEN loc.startdate AND loc.enddate)
                    OR (:endDate BETWEEN loc.startdate AND loc.enddate)
                    OR (loc.startdate BETWEEN :startDate AND :endDate)
                    OR (loc.enddate BETWEEN :startDate AND :endDate)
                )
            ))')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('pickupLocation', $pickupLocation)
            ->setParameter('dropoffLocation', $dropoffLocation);

        // Filtre par transmission
        if ($gearbox) {
            $qb->andWhere('c.gearbox = :gearbox')
            ->setParameter('gearbox', $gearbox);
        }

        // Filtre par nombre de portes
        if ($doors) {
            $qb->andWhere('c.nbofcardoors = :doors')
                ->setParameter('doors', $doors);
        }

        // Tri par prix
        if ($priceOrder === 'asc') {
            $qb->orderBy('c.dayprice', 'ASC');
        } elseif ($priceOrder === 'desc') {
            $qb->orderBy('c.dayprice', 'DESC');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Obtenir les voitures recommandées.
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
