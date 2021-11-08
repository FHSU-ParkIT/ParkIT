<?php

namespace App\Entity;

use App\Repository\LicensePlatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicensePlatesRepository::class)
 */
class LicensePlates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="licensePlates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $plateNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }
}
