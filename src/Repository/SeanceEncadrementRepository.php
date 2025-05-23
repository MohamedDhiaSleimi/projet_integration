<?php
namespace App\Repository;

use App\Entity\SeanceEncadrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SeanceEncadrementRepository extends ServiceEntityRepository
 {
    public function __construct( ManagerRegistry $registry )
 {
        parent::__construct( $registry, SeanceEncadrement::class );
    }

    // Recherche des séances par étudiant et par date

    public function findByStudentAndDate( $student, \DateTime $date )
 {
        return $this->createQueryBuilder( 's' )
        ->andWhere( 's.student = :student' )
        ->andWhere( 's.date >= :date' ) // Séances passées ou futures
        ->setParameter( 'student', $student )
        ->setParameter( 'date', $date )
        ->orderBy( 's.date', 'ASC' )
        ->getQuery()
        ->getResult();
    }
}