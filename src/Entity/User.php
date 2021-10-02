<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $last_name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $second_name;

	/**
	 * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="user")
	 */
	private $tickets;

	public function __construct()
	{
		$this->tickets = new ArrayCollection();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->last_name;
	}

	public function setLastName(string $last_name): self
	{
		$this->last_name = $last_name;

		return $this;
	}

	public function getSecondName(): ?string
	{
		return $this->second_name;
	}

	public function setSecondName(?string $second_name): self
	{
		$this->second_name = $second_name;

		return $this;
	}

	/**
	 * @return Collection|Ticket[]
	 */
	public function getTickets(): Collection
	{
		return $this->tickets;
	}

	public function addTicket(Ticket $ticket): self
	{
		if (!$this->tickets->contains($ticket)) {
			$this->tickets[] = $ticket;
			$ticket->setUser($this);
		}

		return $this;
	}

	public function removeTicket(Ticket $ticket): self
	{
		if ($this->tickets->removeElement($ticket)) {
			// set the owning side to null (unless already changed)
			if ($ticket->getUser() === $this) {
				$ticket->setUser(null);
			}
		}

		return $this;
	}
}
