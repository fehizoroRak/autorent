<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registration = null;

    #[ORM\Column(nullable: true)]
    private ?float $dayprice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null; // Nouvelle propriété image

    /**
     * @var Collection<int, Location>
     */
    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'car')]
    private Collection $locations;

    #[ORM\Column]
    private ?bool $availability = null;

    #[ORM\Column]
    private ?int $nbofcardoors = null;

    #[ORM\Column]
    private ?int $nbofpersons = null;

    #[ORM\Column]
    private ?bool $isAirconditionner = null;

    #[ORM\Column(length: 255)]
    private ?string $gearbox = null;

    #[ORM\Column]
    private ?int $horsepower = null;

    #[ORM\Column]
    private ?int $co2emissions = null;

    #[ORM\Column]
    private ?bool $isElectric = null;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(?string $registration): static
    {
        $this->registration = $registration;

        return $this;
    }

    public function getDayprice(): ?float
    {
        return $this->dayprice;
    }

    public function setDayprice(?float $dayprice): static
    {
        $this->dayprice = $dayprice;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setCar($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getCar() === $this) {
                $location->setCar(null);
            }
        }

        return $this;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function getNbofcardoors(): ?int
    {
        return $this->nbofcardoors;
    }

    public function setNbofcardoors(int $nbofcardoors): static
    {
        $this->nbofcardoors = $nbofcardoors;

        return $this;
    }

    public function getNbofpersons(): ?int
    {
        return $this->nbofpersons;
    }

    public function setNbofpersons(int $nbofpersons): static
    {
        $this->nbofpersons = $nbofpersons;

        return $this;
    }

    public function isAirconditionner(): ?bool
    {
        return $this->isAirconditionner;
    }

    public function setAirconditionner(bool $isAirconditionner): static
    {
        $this->isAirconditionner = $isAirconditionner;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getHorsepower(): ?int
    {
        return $this->horsepower;
    }

    public function setHorsepower(int $horsepower): static
    {
        $this->horsepower = $horsepower;

        return $this;
    }

    public function getCo2emissions(): ?int
    {
        return $this->co2emissions;
    }

    public function setCo2emissions(int $co2emissions): static
    {
        $this->co2emissions = $co2emissions;

        return $this;
    }

    public function isElectric(): ?bool
    {
        return $this->isElectric;
    }

    public function setElectric(bool $isElectric): static
    {
        $this->isElectric = $isElectric;

        return $this;
    }
}
