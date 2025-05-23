<?php

namespace App\Controller;

use App\Entity\SeanceEncadrement;
use App\Form\SeanceEncadrementType;
use App\Repository\SeanceEncadrementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ Route( '/supervisor' ) ]

class SeanceEncadrementController extends AbstractController
 {
    #[ Route( '/', name: 'seance_index', methods: [ 'GET' ] ) ]

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

    #[ Route( '/new', name: 'seance_new', methods: [ 'GET', 'POST' ] ) ]

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

    #[ Route( '/{id}', name: 'seance_show', methods: [ 'GET' ] ) ]

    public function show( SeanceEncadrement $seance ): Response
 {
        return $this->render( 'seance_encadrement/show.html.twig', [
            'seance' => $seance,
        ] );
    }

    #[ Route( '/{id}/edit', name: 'seance_edit', methods: [ 'GET', 'POST' ] ) ]

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

    #[ Route( '/{id}', name: 'seance_delete', methods: [ 'POST' ] ) ]

    public function delete( Request $request, SeanceEncadrement $seance, EntityManagerInterface $em ): Response
 {
        if ( $this->isCsrfTokenValid( 'delete' . $seance->getId(), $request->request->get( '_token' ) ) ) {
            $em->remove( $seance );
            $em->flush();
        }

        return $this->redirectToRoute( 'seance_index' );
    }
}
