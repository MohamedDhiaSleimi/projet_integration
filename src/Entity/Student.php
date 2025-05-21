<?php
// src/Entity/Student.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Student extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $university = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fieldOfStudy = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Application::class, orphanRemoval: true)]
    private Collection $applications;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: CV::class)]
    private Collection $cvs;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        $this->cvs = new ArrayCollection();
        $this->setRoles(['ROLE_STUDENT']);
    }

    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function setUniversity(?string $university): static
    {
        $this->university = $university;
        return $this;
    }

    public function getFieldOfStudy(): ?string
    {
        return $this->fieldOfStudy;
    }

    public function setFieldOfStudy(?string $fieldOfStudy): static
    {
        $this->fieldOfStudy = $fieldOfStudy;
        return $this;
    }

    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setStudent($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            if ($application->getStudent() === $this) {
                $application->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CV>
     */
    public function getCvs(): Collection
    {
        return $this->cvs;
    }

    public function addCv(CV $cv): static
    {
        if (!$this->cvs->contains($cv)) {
            $this->cvs->add($cv);
            $cv->setStudent($this);
        }

        return $this;
    }

    public function removeCv(CV $cv): static
    {
        if ($this->cvs->removeElement($cv)) {
            if ($cv->getStudent() === $this) {
                $cv->setStudent(null);
            }
        }

        return $this;
    }
}
