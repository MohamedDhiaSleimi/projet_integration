<?php
// src/Entity/Application.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?InternshipOffer $internshipOffer = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $appliedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $status = 'pending';

    public function __construct()
    {
        $this->appliedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;
        return $this;
    }

    public function getInternshipOffer(): ?InternshipOffer
    {
        return $this->internshipOffer;
    }

    public function setInternshipOffer(?InternshipOffer $internshipOffer): static
    {
        $this->internshipOffer = $internshipOffer;
        return $this;
    }

    public function getAppliedAt(): ?\DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function setAppliedAt(\DateTimeImmutable $appliedAt): static
    {
        $this->appliedAt = $appliedAt;

        return $this;
    }
}
