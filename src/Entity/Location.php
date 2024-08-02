<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startdate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $enddate = null;

    #[ORM\Column]
    private ?float $totalamount = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[ORM\ManyToOne(targetEntity: CityPickupLocation::class, inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CityPickupLocation $pickupLocation = null;

    #[ORM\ManyToOne(targetEntity: CityDropoffLocation::class, inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CityDropoffLocation $dropoffLocation = null;

    #[ORM\ManyToOne(targetEntity: Pack::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Pack $pack = null;

    #[ORM\ManyToMany(targetEntity: Option::class)]
    private Collection $options;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'location')]
    private Collection $payments;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $starttime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endtime = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfDays = null;

    /**
     * @var Collection<int, Status>
     */
    #[ORM\ManyToMany(targetEntity: Status::class, mappedBy: 'location_status')]
    private Collection $statuses;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->statuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): static
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTimeInterface $enddate): static
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getTotalamount(): ?float
    {
        return $this->totalamount;
    }

    public function setTotalamount(float $totalamount): static
    {
        $this->totalamount = $totalamount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getPickupLocation(): ?CityPickupLocation
    {
        return $this->pickupLocation;
    }

    public function setPickupLocation(?CityPickupLocation $pickupLocation): static
    {
        $this->pickupLocation = $pickupLocation;

        return $this;
    }

    public function getDropoffLocation(): ?CityDropoffLocation
    {
        return $this->dropoffLocation;
    }

    public function setDropoffLocation(?CityDropoffLocation $dropoffLocation): static
    {
        $this->dropoffLocation = $dropoffLocation;

        return $this;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): static
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    public function removeOption(Option $option): static
    {
        $this->options->removeElement($option);

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setLocation($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            if ($payment->getLocation() === $this) {
                $payment->setLocation(null);
            }
        }

        return $this;
    }

    public function getStarttime(): ?\DateTimeInterface
    {
        return $this->starttime;
    }

    public function setStarttime(?\DateTimeInterface $starttime): static
    {
        $this->starttime = $starttime;

        return $this;
    }

    public function getEndtime(): ?\DateTimeInterface
    {
        return $this->endtime;
    }

    public function setEndtime(?\DateTimeInterface $endtime): static
    {
        $this->endtime = $endtime;

        return $this;
    }

    public function getNumberOfDays(): ?int
    {
        return $this->numberOfDays;
    }

    public function setNumberOfDays(?int $numberOfDays): static
    {
        $this->numberOfDays = $numberOfDays;

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): static
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses->add($status);
            $status->addLocationStatus($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): static
    {
        if ($this->statuses->removeElement($status)) {
            $status->removeLocationStatus($this);
        }

        return $this;
    }
}
