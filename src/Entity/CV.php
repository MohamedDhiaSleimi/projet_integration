<?php

namespace App\Entity;

use App\Repository\CVRepository;
use Doctrine\ORM\Mapping as ORM;

#[ ORM\Entity( repositoryClass: CVRepository::class ) ]

class CV {
    #[ ORM\Id ]
    #[ ORM\GeneratedValue ]
    #[ ORM\Column ]
    private ?int $id = null;

    #[ ORM\ManyToOne( inversedBy: 'cvs' ) ]
    #[ ORM\JoinColumn( nullable: false ) ]
    private ?Student $student = null;

    #[ ORM\Column( length: 255 ) ]
    private ?string $filename = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getStudent(): ?Student {
        return $this->student;
    }

    public function setStudent( Student $student ): static {
        $this->student = $student;
        return $this;
    }

    public function getFilename(): ?string {
        return $this->filename;
    }

    public function setFilename( string $filename ): static {
        $this->filename = $filename;
        return $this;
    }
}
