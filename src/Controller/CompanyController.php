<?php
// src/Controller/CompanyController.php
namespace App\Controller;

use App\Entity\Application;
use App\Entity\InternshipOffer;
use App\Form\InternshipOfferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route( '/company' ) ]

class CompanyController extends AbstractController {
    #[ Route( '/', name: 'app_company_dashboard' ) ]

    public function dashboard(): Response {
        return $this->render( 'company/dashboard.html.twig' );
    }

    #[ Route( '/offers', name: 'app_company_offers' ) ]

    public function myOffers( EntityManagerInterface $entityManager ): Response {
        $company = $this->getUser();
        $offers = $entityManager->getRepository( InternshipOffer::class )->findBy( [ 'company' => $company ] );

        return $this->render( 'company/offers.html.twig', [
            'offers' => $offers
        ] );
    }

    #[ Route( '/offers/new', name: 'app_company_new_offer' ) ]

    public function newOffer( Request $request, EntityManagerInterface $entityManager ): Response {
        $offer = new InternshipOffer();
        $offer->setCompany( $this->getUser() );

        $form = $this->createForm( InternshipOfferType::class, $offer );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist( $offer );
            $entityManager->flush();

            $this->addFlash( 'success', 'Your internship offer has been posted.' );
            return $this->redirectToRoute( 'app_company_offers' );
        }

        return $this->render( 'company/new_offer.html.twig', [
            'form' => $form->createView()
        ] );
    }

    #[ Route( '/offers/{id}/applicants', name: 'app_company_offer_applicants' ) ]

    public function viewApplicants( InternshipOffer $offer ): Response {
        // Security check
        if ( $offer->getCompany() !== $this->getUser() ) {
            throw $this->createAccessDeniedException( 'You cannot access this offer.' );
        }

        return $this->render( 'company/applicants.html.twig', [
            'offer' => $offer,
            'applications' => $offer->getApplications()
        ] );
    }

    #[ Route( '/applications/{id}/accept', name: 'app_company_accept_application' ) ]

    public function acceptApplication(
        Application $application,
        EntityManagerInterface $entityManager
    ): Response {
        $offer = $application->getInternshipOffer();

        // Security check
        if ( $offer->getCompany() !== $this->getUser() ) {
            throw $this->createAccessDeniedException( 'You cannot manage this application.' );
        }

        $application->setStatus( 'accepted' );
        $entityManager->flush();

        $this->addFlash( 'success', 'Application has been accepted.' );
        return $this->redirectToRoute( 'app_company_offer_applicants', [ 'id' => $offer->getId() ] );
    }

    #[ Route( '/applications/{id}/reject', name: 'app_company_reject_application' ) ]

    public function rejectApplication(
        Application $application,
        EntityManagerInterface $entityManager
    ): Response {
        $offer = $application->getInternshipOffer();

        // Security check
        if ( $offer->getCompany() !== $this->getUser() ) {
            throw $this->createAccessDeniedException( 'You cannot manage this application.' );
        }

        $application->setStatus( 'rejected' );
        $entityManager->flush();

        $this->addFlash( 'success', 'Application has been rejected.' );
        return $this->redirectToRoute( 'app_company_offer_applicants', [ 'id' => $offer->getId() ] );
    }
}