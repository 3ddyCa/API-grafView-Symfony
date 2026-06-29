<?php

namespace App\Entity;

use App\Repository\TodayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodayRepository::class)]
class Today
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $currentDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $TC = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $TCmax = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $TCmin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $sunrise = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $sunset = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $pressure = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $humidity = null;

    #[ORM\Column]
    private ?int $fk_city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentDate(): ?\DateTime
    {
        return $this->currentDate;
    }

    public function setCurrentDate(\DateTime $currentDate): static
    {
        $this->currentDate = $currentDate;

        return $this;
    }

    public function getTC(): ?string
    {
        return $this->TC;
    }

    public function setTC(string $TC): static
    {
        $this->TC = $TC;

        return $this;
    }

    public function getTCmax(): ?string
    {
        return $this->TCmax;
    }

    public function setTCmax(string $TCmax): static
    {
        $this->TCmax = $TCmax;

        return $this;
    }

    public function getTCmin(): ?string
    {
        return $this->TCmin;
    }

    public function setTCmin(string $TCmin): static
    {
        $this->TCmin = $TCmin;

        return $this;
    }

    public function getSunrise(): ?\DateTime
    {
        return $this->sunrise;
    }

    public function setSunrise(\DateTime $sunrise): static
    {
        $this->sunrise = $sunrise;

        return $this;
    }

    public function getSunset(): ?\DateTime
    {
        return $this->sunset;
    }

    public function setSunset(\DateTime $sunset): static
    {
        $this->sunset = $sunset;

        return $this;
    }

    public function getPressure(): ?string
    {
        return $this->pressure;
    }

    public function setPressure(string $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getFkCity(): ?int
    {
        return $this->fk_city;
    }

    public function setFkCity(int $fk_city): static
    {
        $this->fk_city = $fk_city;

        return $this;
    }
}
