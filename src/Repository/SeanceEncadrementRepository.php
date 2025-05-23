<?php
namespace App\Repository;

use App\Entity\SeanceEncadrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SeanceEncadrementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceEncadrement::class);
    }

    public function findPastSessions($student, \DateTime $now)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.Student = :student')
            ->andWhere('s.date < :now')
            ->setParameter('student', $student)
            ->setParameter('now', $now)
            ->orderBy('s.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findFutureSessions($student, \DateTime $now)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.Student = :student')
            ->andWhere('s.date >= :now')
            ->setParameter('student', $student)
            ->setParameter('now', $now)
            ->orderBy('s.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
