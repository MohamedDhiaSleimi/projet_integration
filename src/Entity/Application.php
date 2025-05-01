<?php
// src/Entity/Application.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ ORM\Entity ]

class Application {
    #[ ORM\Id ]
    #[ ORM\GeneratedValue ]
    #[ ORM\Column ]
    private ?int $id = null;

    #[ ORM\ManyToOne( inversedBy: 'applications' ) ]
    #[ ORM\JoinColumn( nullable: false ) ]
    private ?Student $student = null;

    #[ ORM\ManyToOne( inversedBy: 'applications' ) ]
    #[ ORM\JoinColumn( nullable: false ) ]
    private ?InternshipOffer $internshipOffer = null;

    #[ ORM\Column ]
    private ?\DateTimeImmutable $appliedAt = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $status = 'pending';

    #[ ORM\ManyToOne( inversedBy: 'applications' ) ]
    private ?Supervisor $supervisor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    public function __construct() {
        $this->appliedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getStudent(): ?Student {
        return $this->student;
    }

    public function setStudent( ?Student $student ): static {
        $this->student = $student;
        return $this;
    }

    public function getInternshipOffer(): ?InternshipOffer {
        return $this->internshipOffer;
    }

    public function setInternshipOffer( ?InternshipOffer $internshipOffer ): static {
        $this->internshipOffer = $internshipOffer;
        return $this;
    }

    public function getAppliedAt(): ?\DateTimeImmutable {
        return $this->appliedAt;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus( string $status ): static {
        $this->status = $status;
        return $this;
    }

    public function setAppliedAt( \DateTimeImmutable $appliedAt ): static {
        $this->appliedAt = $appliedAt;

        return $this;
    }

    public function getSupervisor(): ?Supervisor {
        return $this->supervisor;
    }

    public function setSupervisor( ?Supervisor $supervisor ): static {
        $this->supervisor = $supervisor;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }
}
