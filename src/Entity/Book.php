<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
  private $title;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $author;

  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $date_publish;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $summary;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getAuthor(): ?string
  {
    return $this->author;
  }

  public function setAuthor(string $author): self
  {
    $this->author = $author;

    return $this;
  }

  public function getDatePublish(): ?\DateTimeInterface
  {
    return $this->date_publish;
  }

  public function setDatePublish(?\DateTimeInterface $date_publish): self
  {
    $this->date_publish = $date_publish;

    return $this;
  }

  public function getSummary(): ?string
  {
    return $this->summary;
  }

  public function setSummary(?string $summary): self
  {
    $this->summary = $summary;

    return $this;
  }
}