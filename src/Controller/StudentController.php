<?php
// src/Controller/StudentController.php
namespace App\Controller;

use App\Entity\Application;
use App\Entity\InternshipOffer;
use App\Entity\SeanceEncadrement;
use App\Repository\InternshipOfferRepository;
use App\Repository\SeanceEncadrementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route( '/student' ) ]

class StudentController extends AbstractController {
    #[ Route( '/', name: 'app_student_dashboard' ) ]

    public function dashboard(): Response {
        return $this->render( 'student/dashboard.html.twig' );
    }

    #[ Route( '/offers', name: 'app_student_offers' ) ]

    public function listOffers( InternshipOfferRepository $offerRepository ): Response {
        $offers = $offerRepository->findAll();

        return $this->render( 'student/offers.html.twig', [
            'offers' => $offers
        ] );
    }
    #[ Route( '/supervision/history', name: 'app_student_supervision_history' ) ]

    public function supervisionHistory( EntityManagerInterface $entityManager ): Response {
        $Student = $this->getUser();
        $history = $entityManager->getRepository( SeanceEncadrement::class )
        ->findBy( [ 'Student' => $Student ] );

        return $this->render( 'student/supervision_history.html.twig', [
            'sessions' => $history
        ] );
    }

    #[ Route( '/offers/{id}', name: 'app_student_offer_details' ) ]

    public function offerDetails( InternshipOffer $offer ): Response {
        return $this->render( 'student/offer_details.html.twig', [
            'offer' => $offer
        ] );
    }

    #[ Route( '/apply/{id}', name: 'app_student_apply' ) ]

    public function apply( InternshipOffer $offer, EntityManagerInterface $entityManager ): Response {
        $Student = $this->getUser();

        // Check if already applied
        $existingApplication = $entityManager->getRepository( Application::class )->findOneBy( [
            'Student' => $Student,
            'internshipOffer' => $offer
        ] );

        if ( $existingApplication ) {
            $this->addFlash( 'warning', 'You have already applied to this offer.' );
            return $this->redirectToRoute( 'app_student_offer_details', [ 'id' => $offer->getId() ] );
        }

        $application = new Application();
        $application->setStudent( $Student );
        $application->setInternshipOffer( $offer );
        $application->setStatus( 'pending' );

        $entityManager->persist( $application );
        $entityManager->flush();

        $this->addFlash( 'success', 'Your application has been submitted.' );
        return $this->redirectToRoute( 'app_student_offers' );
    }

    #[ Route( '/my-applications', name: 'app_student_applications' ) ]

    public function myApplications( EntityManagerInterface $entityManager ): Response {
        $Student = $this->getUser();
        $applications = $entityManager->getRepository( Application::class )->findBy( [ 'student' => $Student ] );

        return $this->render( 'student/my_applications.html.twig', [
            'applications' => $applications
        ] );
    }
    #[ Route( '/seances', name: 'student_seances' ) ]

    public function seances( SeanceEncadrementRepository $seanceRepository ): Response {
        $Student = $this->getUser();

        // Récupérer les séances passées et futures
        $seancesPassées = $seanceRepository->findByStudentAndDate( $Student, new \DateTime( '-1 day' ) );
        // Séances passées
        $seancesFutures = $seanceRepository->findByStudentAndDate( $Student, new \DateTime( '+1 day' ) );
        // Séances futures

        return $this->render( 'student/seances.html.twig', [
            'seances_passees' => $seancesPassées,
            'seances_futures' => $seancesFutures
        ] );
    }
}
