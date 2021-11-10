<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LicensePlate::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $licensePlate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDateTime;

    /**
     * @ORM\ManyToOne(targetEntity=ParkingSpot::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parkingSpot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?LicensePlate
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?LicensePlate $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getParkingSpot(): ?ParkingSpot
    {
        return $this->parkingSpot;
    }

    public function setParkingSpot(?ParkingSpot $parkingSpot): self
    {
        $this->parkingSpot = $parkingSpot;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
