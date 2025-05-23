<?php
// src/Controller/SupervisorController.php
namespace App\Controller;

use App\Entity\Application;
use App\Entity\Supervisor;
use App\Entity\InternshipOffer;
use App\Form\SuppervisorType;
use App\Form\AssignSupervisorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route( '/admin' ) ]

class SupervisorController extends AbstractController {
    #[ Route( '/supervisors', name: 'app_admin_supervisors' ) ]

    public function listSupervisors( EntityManagerInterface $entityManager ): Response {
        $supervisors = $entityManager->getRepository( Supervisor::class )->findAll();

        return $this->render( 'admin/supervisors/supervisors.html.twig', [
            'supervisors' => $supervisors
        ] );
    }

    #[ Route( '/supervisors/new', name: 'app_admin_new_supervisor' ) ]

    public function newSupervisor( Request $request, EntityManagerInterface $entityManager ): Response {
        $supervisor = new Supervisor();

        $form = $this->createForm( SuppervisorType::class, $supervisor );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist( $supervisor );
            $entityManager->flush();

            $this->addFlash( 'success', 'New supervisor has been added.' );
            return $this->redirectToRoute( 'app_admin_supervisors' );
        }

        return $this->render( 'admin/supervisors/new_supervisors.html.twig', [
            'form' => $form->createView()
        ] );
    }

    #[ Route( '/applications/assign-supervisors', name: 'app_admin_assign_supervisors' ) ]

    public function assignSupervisors( EntityManagerInterface $entityManager ): Response {
        $applications = $entityManager->getRepository( Application::class )
            ->findBy( [ 'status' => 'accepted', 'supervisor' => null ] );

        return $this->render( 'admin/supervisors/assign_supervisors.html.twig', [
            'applications' => $applications
        ] );
    }

    #[ Route( '/applications/{id}/assign', name: 'app_admin_assign_supervisor' ) ]

    public function assignSupervisor(
        Application $application,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm( AssignSupervisorType::class, $application );
        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->flush();

            $this->addFlash( 'success', 'Supervisor assigned successfully.' );
            return $this->redirectToRoute( 'app_admin_assign_supervisors' );
        }

        return $this->render( 'admin/assign_supervisor.html.twig', [
            'application' => $application,
            'form' => $form->createView()
        ] );
    }
}