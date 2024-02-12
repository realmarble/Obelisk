<?php

namespace Modules\HR\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $identityid = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $position = null;

    #[ORM\Column]
    private ?bool $employed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $hired = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fired = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentityid(): ?string
    {
        return $this->identityid;
    }

    public function setIdentityid(string $identityid): static
    {
        $this->identityid = $identityid;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isEmployed(): ?bool
    {
        return $this->employed;
    }

    public function setEmployed(bool $employed): static
    {
        $this->employed = $employed;

        return $this;
    }

    public function getHired(): ?\DateTimeInterface
    {
        return $this->hired;
    }

    public function setHired(\DateTimeInterface $hired): static
    {
        $this->hired = $hired;

        return $this;
    }

    public function getFired(): ?\DateTimeInterface
    {
        return $this->fired;
    }

    public function setFired(?\DateTimeInterface $fired): static
    {
        $this->fired = $fired;

        return $this;
    }
}
