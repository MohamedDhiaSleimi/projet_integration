<?php
// src/Entity/Supervisor.php
namespace App\Entity;

use App\Repository\SupervisorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ ORM\Entity( repositoryClass: SupervisorRepository::class ) ]

class Supervisor extends User {
    #[ ORM\Column( length: 255, nullable: true ) ]
    private ?string $department = null;

    #[ ORM\Column( length: 255, nullable: true ) ]
    private ?string $phoneNumber = null;

    /**
    * @var Collection<int, Application>
    */
    #[ ORM\OneToMany( targetEntity: Application::class, mappedBy: 'supervisor' ) ]
    private Collection $applications;
    #[ ORM\OneToMany( mappedBy: 'encadrant', targetEntity: SeanceEncadrement::class, orphanRemoval: true ) ]
    private Collection $seances;

    public function __construct() {
        $this->applications = new ArrayCollection();
        $this->seances = new ArrayCollection();
        $this->setRoles( [ 'ROLE_SUPERVISOR' ] );
    }

    public function getDepartment(): ?string {
        return $this->department;
    }

    public function setDepartment( ?string $department ): static {
        $this->department = $department;

        return $this;
    }

    public function getPhoneNumber(): ?string {
        return $this->phoneNumber;
    }

    public function setPhoneNumber( ?string $phoneNumber ): static {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
    * @return Collection<int, Application>
    */

    public function getApplications(): Collection {
        return $this->applications;
    }

    public function addApplication( Application $application ): static {
        if ( !$this->applications->contains( $application ) ) {
            $this->applications->add( $application );
            $application->setSupervisor( $this );
        }

        return $this;
    }
    /**
    * @return Collection<int, SeanceEncadrement>
    */

    public function getSeances(): Collection {
        return $this->seances;
    }

    public function addSeance( SeanceEncadrement $seance ): static {
        if ( !$this->seances->contains( $seance ) ) {
            $this->seances->add( $seance );
            $seance->setSupervisor( $this );
        }

        return $this;
    }

    public function removeSeance( SeanceEncadrement $seance ): static {
        if ( $this->seances->removeElement( $seance ) ) {
            if ( $seance->getSupervisor() === $this ) {
                $seance->setSupervisor( null );
            }
        }

        return $this;
    }

    public function removeApplication( Application $application ): static {
        if ( $this->applications->removeElement( $application ) ) {
            if ( $application->getSupervisor() === $this ) {
                $application->setSupervisor( null );
            }
        }

        return $this;
    }
}
