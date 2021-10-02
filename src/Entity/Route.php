<?php

namespace App\Entity;

use App\Repository\RouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RouteRepository::class)
 */
class Route
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_end;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="routes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $station_from;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $station_to;

    /**
     * @ORM\ManyToMany(targetEntity=Train::class)
     */
    private $trains;

    /** @var int  */
    private $maxSeatsCnt = 0;

    public function __construct()
    {
        $this->trains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function getDateStartString(): ?string
    {
        return $this->date_start->format('Y-m-d H:i:s');
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

	public function getDateEndString(): ?string
	{
		return $this->date_end->format('Y-m-d H:i:s');
	}

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStationFrom(): ?Station
    {
        return $this->station_from;
    }

    public function setStationFrom(?Station $station_from): self
    {
        $this->station_from = $station_from;

        return $this;
    }

    public function getStationTo(): ?Station
    {
        return $this->station_to;
    }

    public function setStationTo(?Station $station_to): self
    {
        $this->station_to = $station_to;

        return $this;
    }

    /**
     * @return Collection|Train[]
     */
    public function getTrains(): Collection
    {
        return $this->trains;
    }

    public function addTrain(Train $train): self
    {
        if (!$this->trains->contains($train)) {
            $this->trains[] = $train;
        }

        return $this;
    }

    public function removeTrain(Train $train): self
    {
        $this->trains->removeElement($train);

        return $this;
    }

	/**
	 * @return int
	 */
    public function getMaxSeatsCnt(): int
	{
		return $this->maxSeatsCnt;
	}

	public function calcMaxSeatsCnt(): void
	{
		/** @var Train $train */
		foreach ($this->trains as $train)
		{
			$this->maxSeatsCnt += $train->getMaxSeatsCnt();
		}
	}
}
