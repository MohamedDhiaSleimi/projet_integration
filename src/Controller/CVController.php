<?php

namespace App\Controller;

use App\Entity\CV;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ Route( '/cv' ) ]

class CVController extends AbstractController {

    #[ Route( '/', name: 'app_cv_index', methods: [ 'GET', 'POST' ] ) ]
    #[ IsGranted( 'ROLE_STUDENT' ) ]

    public function index( Request $request, EntityManagerInterface $em, SluggerInterface $slugger ): Response {
        /** @var Student $student */
        $student = $this->getUser();
        $cv = $em->getRepository( CV::class )->findOneBy( [ 'student' => $student ] );

        if ( $request->isMethod( 'POST' ) && $request->files->get( 'cv_file' ) ) {
            $pdfFile = $request->files->get( 'cv_file' );
            if ( $pdfFile->getClientOriginalExtension() !== 'pdf' ) {
                $this->addFlash( 'danger', 'Only PDF files are allowed.' );
            } else {
                $originalFilename = pathinfo( $pdfFile->getClientOriginalName(), PATHINFO_FILENAME );
                $safeFilename = $slugger->slug( $originalFilename );
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();

                try {
                    $pdfFile->move(
                        $this->getParameter( 'cv_directory' ),
                        $newFilename
                    );
                } catch ( FileException $e ) {
                    $this->addFlash( 'danger', 'Failed to upload CV.' );
                }

                if ( !$cv ) {
                    $cv = new CV();
                    $cv->setStudent( $student );
                    $em->persist( $cv );
                } else {
                    // Remove old file if needed
                    $oldPath = $this->getParameter( 'cv_directory' ) . '/' . $cv->getFilename();
                    if ( file_exists( $oldPath ) ) {
                        unlink( $oldPath );
                    }
                }

                $cv->setFilename( $newFilename );
                $em->flush();

                $this->addFlash( 'success', 'CV uploaded successfully.' );
                return $this->redirectToRoute( 'app_cv_index' );
            }
        }

        return $this->render( 'cv/index.html.twig', [
            'cv' => $cv,
        ] );
    }

    #[ Route( '/company/view/{id}', name: 'app_cv_company_view', methods: [ 'GET' ] ) ]
    #[ IsGranted( 'ROLE_COMPANY' ) ]

    public function companyView( CV $cv ): Response {
        return $this->render( 'cv/company_view.html.twig', [
            'cv' => $cv,
        ] );
    }

    #[ Route( '/download/{id}', name: 'app_cv_download', methods: [ 'GET' ] ) ]
    #[ IsGranted( 'ROLE_COMPANY' ) ]

    public function download( CV $cv ): Response {
        $file = $this->getParameter( 'cv_directory' ) . '/' . $cv->getFilename();

        return $this->file( $file );
    }
}
