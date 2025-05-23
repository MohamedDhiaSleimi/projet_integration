<?php
// src/Entity/InternshipOffer.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InternshipOfferRepository;

#[ ORM\Entity( repositoryClass: InternshipOfferRepository::class ) ]

class InternshipOffer
 {
    #[ ORM\Id ]
    #[ ORM\GeneratedValue ]
    #[ ORM\Column ]
    private ?int $id = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $title = null;

    #[ ORM\Column( type: 'text' ) ]
    private ?string $description = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $location = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $duration = null;

    #[ ORM\Column ]
    private ?\DateTimeImmutable $createdAt = null;

    #[ ORM\Column( type: 'boolean' ) ]
    private bool $isActive = true;
    // <-- new field added here

    #[ ORM\ManyToOne( inversedBy: 'internshipOffers' ) ]
    #[ ORM\JoinColumn( nullable: false ) ]
    private ?Company $company = null;

    #[ ORM\OneToMany( mappedBy: 'internshipOffer', targetEntity: Application::class, orphanRemoval: true ) ]
    private Collection $applications;

    public function __construct()
 {
        $this->applications = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->isActive = true;
        // default to active
    }

    public function getId(): ?int
 {
        return $this->id;
    }

    public function getTitle(): ?string
 {
        return $this->title;
    }

    public function setTitle( string $title ): static
 {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
 {
        return $this->description;
    }

    public function setDescription( string $description ): static
 {
        $this->description = $description;
        return $this;
    }

    public function getLocation(): ?string
 {
        return $this->location;
    }

    public function setLocation( string $location ): static
 {
        $this->location = $location;
        return $this;
    }

    public function getDuration(): ?string
 {
        return $this->duration;
    }

    public function setDuration( string $duration ): static
 {
        $this->duration = $duration;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
 {
        return $this->createdAt;
    }

    public function getCompany(): ?Company
 {
        return $this->company;
    }

    public function setCompany( ?Company $company ): static
 {
        $this->company = $company;
        return $this;
    }

    public function getApplications(): Collection
 {
        return $this->applications;
    }

    public function addApplication( Application $application ): static
 {
        if ( !$this->applications->contains( $application ) ) {
            $this->applications->add( $application );
            $application->setInternshipOffer( $this );
        }

        return $this;
    }

    public function removeApplication( Application $application ): static
 {
        if ( $this->applications->removeElement( $application ) ) {
            if ( $application->getInternshipOffer() === $this ) {
                $application->setInternshipOffer( null );
            }
        }

        return $this;
    }

    public function setCreatedAt( \DateTimeImmutable $createdAt ): static
 {
        $this->createdAt = $createdAt;

        return $this;
    }

    // ... existing getters and setters ...

    public function isActive(): bool
 {
        return $this->isActive;
    }

    public function setIsActive( bool $isActive ): static
 {
        $this->isActive = $isActive;
        return $this;
    }
}
