<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Length(
   *    min = 3,
   *    max = 30,
   *    minMessage = "Ce champ doit contenir au moins {{ limit }} charactères",
   *    maxMessage = "Ce champ doit contenir maximum {{ limit }} charactères"
   * )
   */
  private $ls_name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   * @Assert\Length(
   *    min = 3,
   *    max = 30,
   *    minMessage = "Ce champ doit contenir au moins {{ limit }} charactères",
   *    maxMessage = "Ce champ doit contenir maximum {{ limit }} charactères"
   * )
   */
  private $fs_name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $notes;

  /**
   * @ORM\Column(type="boolean")
   */
  private $confirmed;

  /**
   * @ORM\Column(type="string", length=100, nullable=true)
   * @Assert\Email(
   *    message = "{{ value }} n'est pas une adresse mail valide"
   * )
   */
  private $email;

  /**
   * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="persons")
   */
  private $team;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getLsName(): ?string
  {
    return $this->ls_name;
  }

  public function setLsName(string $ls_name): self
  {
    $this->ls_name = $ls_name;

    return $this;
  }

  public function getFsName(): ?string
  {
    return $this->fs_name;
  }

  public function setFsName(?string $fs_name): self
  {
    $this->fs_name = $fs_name;

    return $this;
  }

  public function getNotes(): ?string
  {
    return $this->notes;
  }

  public function setNotes(?string $notes): self
  {
    $this->notes = $notes;

    return $this;
  }

  public function getConfirmed(): ?bool
  {
    return $this->confirmed;
  }

  public function setConfirmed(bool $confirmed): self
  {
    $this->confirmed = $confirmed;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(?string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getTeam(): ?Team
  {
      return $this->team;
  }

  public function setTeam(?Team $team): self
  {
      $this->team = $team;

      return $this;
  }
}