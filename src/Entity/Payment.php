<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paymentdate = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paymentmode = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentdate(): ?\DateTimeInterface
    {
        return $this->paymentdate;
    }

    public function setPaymentdate(?\DateTimeInterface $paymentdate): static
    {
        $this->paymentdate = $paymentdate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentmode(): ?string
    {
        return $this->paymentmode;
    }

    public function setPaymentmode(?string $paymentmode): static
    {
        $this->paymentmode = $paymentmode;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}
