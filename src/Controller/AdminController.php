<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\InternshipOffer;
use App\Entity\SeanceEncadrement;
use App\Entity\Student;
use App\Entity\Supervisor;
use App\Form\SeanceEncadrementType;
use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use App\Repository\InternshipOfferRepository;
use App\Repository\SeanceEncadrementRepository;
use App\Repository\StudentRepository;
use App\Repository\SupervisorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
#[ Route( '/admin' ) ]

class AdminController extends AbstractController
 {
    #[ Route( '/', name: 'app_admin_dashboard' ) ]

    public function dashboard(
        StudentRepository $studentRepository,
        CompanyRepository $companyRepository,
        SupervisorRepository $supervisorRepository,
        InternshipOfferRepository $offerRepository,
        ApplicationRepository $applicationRepository
    ): Response {
        return $this->render( 'admin/dashboard.html.twig', [
            'students_count' => $studentRepository->count( [] ),
            'companies_count' => $companyRepository->count( [] ),
            'supervisors_count' => $supervisorRepository->count( [] ),
            'offers_count' => $offerRepository->count( [] ),
            'recent_applications' => $applicationRepository->findBy( [], [ 'appliedAt' => 'DESC' ], 5 ),
            'recent_offers' => $offerRepository->findBy( [], [ 'createdAt' => 'DESC' ], 5 ),
        ] );
    }

    #[ Route( '/students', name: 'app_admin_student_index' ) ]

    public function students( StudentRepository $studentRepository ): Response
 {
        return $this->render( 'admin/student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ] );
    }

    #[ Route( '/companies', name: 'app_admin_company_index' ) ]

    public function companies( CompanyRepository $companyRepository ): Response
 {
        return $this->render( 'admin/company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ] );
    }

    #[ Route( '/supervisors', name: 'app_admin_supervisor_index' ) ]

    public function supervisors( SupervisorRepository $supervisorRepository ): Response
 {
        return $this->render( 'admin/supervisors/supervisors.html.twig', [
            'supervisors' => $supervisorRepository->findAll(),
        ] );
    }

    #[ Route( '/offers', name: 'app_admin_offer_index' ) ]

    public function offers( InternshipOfferRepository $offerRepository ): Response
 {
        return $this->render( 'admin/offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ] );
    }

    #[ Route( '/applications', name: 'app_admin_application_index' ) ]

    public function applications( ApplicationRepository $applicationRepository ): Response
 {
        return $this->render( 'admin/application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ] );
    }
    #[ Route( '/seance', name: 'seance_index', methods: [ 'GET' ] ) ]

    public function index( SeanceEncadrementRepository $repository, Security $security ): Response {
        $user = $security->getUser();

        if ( $this->isGranted( 'ROLE_ADMIN' ) ) {
            $seances = $repository->findAll();
        } else {
            $seances = $repository->findBy( [ 'Supervisor' => $user ] );
        }

        return $this->render( 'seance_encadrement/index.html.twig', [
            'seances' => $seances,
        ] );
    }

    #[ Route( '/seance/new', name: 'seance_new', methods: [ 'GET', 'POST' ] ) ]

    public function new( Request $request, EntityManagerInterface $em ): Response
 {
        $seance = new SeanceEncadrement();
        $form = $this->createForm( SeanceEncadrementType::class, $seance );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $em->persist( $seance );
            $em->flush();

            return $this->redirectToRoute( 'seance_index' );
        }

        return $this->render( 'seance_encadrement/new.html.twig', [
            'form' => $form->createView(),
        ] );
    }

    #[ Route( '/seance/{id}', name: 'seance_show', methods: [ 'GET' ] ) ]

    public function show( SeanceEncadrement $seance ): Response
 {
        return $this->render( 'seance_encadrement/show.html.twig', [
            'seance' => $seance,
        ] );
    }

    #[ Route( '/seance/{id}/edit', name: 'seance_edit', methods: [ 'GET', 'POST' ] ) ]

    public function edit( Request $request, SeanceEncadrement $seance, EntityManagerInterface $em ): Response
 {
        $form = $this->createForm( SeanceEncadrementType::class, $seance );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $em->flush();

            return $this->redirectToRoute( 'seance_index' );
        }

        return $this->render( 'seance_encadrement/edit.html.twig', [
            'form' => $form->createView(),
            'seance' => $seance,
        ] );
    }

    #[ Route( '/seance/{id}', name: 'seance_delete', methods: [ 'POST' ] ) ]

    public function delete( Request $request, SeanceEncadrement $seance, EntityManagerInterface $em ): Response
 {
        if ( $this->isCsrfTokenValid( 'delete' . $seance->getId(), $request->request->get( '_token' ) ) ) {
            $em->remove( $seance );
            $em->flush();
        }

        return $this->redirectToRoute( 'seance_index' );
    }
}
