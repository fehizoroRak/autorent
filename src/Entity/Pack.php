<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $pricePerDay = null;

    #[ORM\Column(nullable: true)]
    private ?float $franchise = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content4 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPricePerDay(): ?float
    {
        return $this->pricePerDay;
    }

    public function setPricePerDay(float $pricePerDay): static
    {
        $this->pricePerDay = $pricePerDay;

        return $this;
    }

    public function getFranchise(): ?float
    {
        return $this->franchise;
    }

    public function setFranchise(?float $franchise): static
    {
        $this->franchise = $franchise;

        return $this;
    }

    public function getContent1(): ?string
    {
        return $this->content1;
    }

    public function setContent1(?string $content1): static
    {
        $this->content1 = $content1;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content2;
    }

    public function setContent2(?string $content2): static
    {
        $this->content2 = $content2;

        return $this;
    }

    public function getContent3(): ?string
    {
        return $this->content3;
    }

    public function setContent3(?string $content3): static
    {
        $this->content3 = $content3;

        return $this;
    }

    public function getContent4(): ?string
    {
        return $this->content4;
    }

    public function setContent4(?string $content4): static
    {
        $this->content4 = $content4;

        return $this;
    }

    public function getContent5(): ?string
    {
        return $this->content5;
    }

    public function setContent5(?string $content5): static
    {
        $this->content5 = $content5;

        return $this;
    }
    public function __toString(): string
    {
   
        return $this->getName() ; 
    }
}
