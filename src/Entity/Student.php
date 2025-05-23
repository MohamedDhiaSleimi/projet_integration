<?php
// src/Entity/Student.php
namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ ORM\Entity( repositoryClass: StudentRepository::class ) ]

class Student extends User
 {
    #[ ORM\Column( length: 255, nullable: true ) ]
    private ?string $university = null;

    #[ ORM\Column( length: 255, nullable: true ) ]
    private ?string $fieldOfStudy = null;

    #[ ORM\OneToMany( mappedBy: 'student', targetEntity: Application::class, orphanRemoval: true ) ]
    private Collection $applications;

    #[ ORM\OneToOne( mappedBy: 'student', targetEntity: CV::class, cascade: [ 'persist', 'remove' ] ) ]
    private ?CV $cv = null;

    public function __construct()
 {
        $this->applications = new ArrayCollection();
        $this->setRoles( [ 'ROLE_STUDENT' ] );
    }

    public function getUniversity(): ?string
 {
        return $this->university;
    }

    public function setUniversity( ?string $university ): static
 {
        $this->university = $university;
        return $this;
    }

    public function getFieldOfStudy(): ?string
 {
        return $this->fieldOfStudy;
    }

    public function setFieldOfStudy( ?string $fieldOfStudy ): static
 {
        $this->fieldOfStudy = $fieldOfStudy;
        return $this;
    }

    /**
    * @return Collection<int, Application>
    */

    public function getApplications(): Collection
 {
        return $this->applications;
    }

    public function addApplication( Application $application ): static
 {
        if ( !$this->applications->contains( $application ) ) {
            $this->applications->add( $application );
            $application->setStudent( $this );
        }

        return $this;
    }

    public function removeApplication( Application $application ): static
 {
        if ( $this->applications->removeElement( $application ) ) {
            if ( $application->getStudent() === $this ) {
                $application->setStudent( null );
            }
        }

        return $this;
    }

    public function getCv(): ?CV
 {
        return $this->cv;
    }

    public function setCv( ?CV $cv ): static
 {
        // set the owning side of the relation if necessary
        if ( $cv !== null && $cv->getStudent() !== $this ) {
            $cv->setStudent( $this );
        }

        $this->cv = $cv;
        return $this;
    }
}
