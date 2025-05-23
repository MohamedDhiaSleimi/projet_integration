<?php

namespace App\Entity;

use App\Repository\SeanceEncadrementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceEncadrementRepository::class)]
class SeanceEncadrement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'text')]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $Student = null;

    #[ORM\ManyToOne(targetEntity: Supervisor::class, inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supervisor $Supervisor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setEtudiant(?Student $Student): self
    {
        $this->Student = $Student;
        return $this;
    }

    public function getSupervisor(): ?Supervisor
    {
        return $this->Supervisor;
    }

    public function setSupervisor(?Supervisor $Supervisor): self
    {
        $this->Supervisor = $Supervisor;
        return $this;
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d H:i');
    }
}
