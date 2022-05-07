<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=40)
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=7)
   */
  private $color;

  /**
   * @ORM\Column(type="string", length=20, nullable=true)
   */
  private $level;

  /**
   * @ORM\Column(type="boolean")
   */
  private $active;

  /**
   * @ORM\Column(type="integer")
   */
  private $members;

  /**
   * @ORM\OneToMany(targetEntity=Person::class, mappedBy="team")
   */
  private $persons;

  public function __construct()
  {
    $this->persons = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getColor(): ?string
  {
    return $this->color;
  }

  public function setColor(string $color): self
  {
    $this->color = $color;

    return $this;
  }

  public function getLevel(): ?string
  {
    return $this->level;
  }

  public function setLevel(?string $level): self
  {
    $this->level = $level;

    return $this;
  }

  public function getActive(): ?bool
  {
    return $this->active;
  }

  public function setActive(bool $active): self
  {
    $this->active = $active;

    return $this;
  }

  public function getMembers(): ?int
  {
    return $this->members;
  }

  public function setMembers(int $members): self
  {
    $this->members = $members;

    return $this;
  }

  /**
   * @return Collection<int, Person>
   */
  public function getPersons(): Collection
  {
    return $this->persons;
  }

  public function addPerson(Person $person): self
  {
    if (!$this->persons->contains($person)) {
      $this->persons[] = $person;
      $person->setTeam($this);
    }

    return $this;
  }

  public function removePerson(Person $person): self
  {
    if ($this->persons->removeElement($person)) {
      // set the owning side to null (unless already changed)
      if ($person->getTeam() === $this) {
        $person->setTeam(null);
      }
    }

    return $this;
  }

  // *** CUSTOM METHOD
  public function __toString(): string
  {
    return $this->name;
  }
}