<?php

namespace App\Entity;

use App\Repository\TrainRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainRepository::class)
 */
class Train
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_seats_cnt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getMaxSeatsCnt(): ?int
    {
        return $this->max_seats_cnt;
    }

    public function setMaxSeatsCnt(int $max_seats_cnt): self
    {
        $this->max_seats_cnt = $max_seats_cnt;

        return $this;
    }
}
