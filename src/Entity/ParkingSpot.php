<?php

namespace App\Entity;

use App\Repository\ParkingSpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkingSpotRepository::class)
 */
class ParkingSpot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $lotName;

    /**
     * @ORM\Column(type="integer")
     */
    private $spotNumber;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="parkingSpot", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLotName(): string
    {
        return $this->lotName;
    }

    public function setLotName(string $lotName): void
    {
        $this->lotName = $lotName;
    }

    public function getSpotNumber(): int
    {
        return $this->spotNumber;
    }

    public function setSpotNumber(int $spotNumber): void
    {
        $this->spotNumber = $spotNumber;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setParkingSpot($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getParkingSpot() === $this) {
                $reservation->setParkingSpot(null);
            }
        }

        return $this;
    }


}
