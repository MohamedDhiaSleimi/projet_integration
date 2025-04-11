<?php
// src/Controller/StudentController.php
namespace App\Controller;

use App\Entity\Application;
use App\Entity\InternshipOffer;
use App\Repository\InternshipOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_student_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('student/dashboard.html.twig');
    }

    #[Route('/offers', name: 'app_student_offers')]
    public function listOffers(InternshipOfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();
        
        return $this->render('student/offers.html.twig', [
            'offers' => $offers
        ]);
    }

    #[Route('/offers/{id}', name: 'app_student_offer_details')]
    public function offerDetails(InternshipOffer $offer): Response
    {
        return $this->render('student/offer_details.html.twig', [
            'offer' => $offer
        ]);
    }

    #[Route('/apply/{id}', name: 'app_student_apply')]
    public function apply(InternshipOffer $offer, EntityManagerInterface $entityManager): Response
    {
        $student = $this->getUser();
        
        // Check if already applied
        $existingApplication = $entityManager->getRepository(Application::class)->findOneBy([
            'student' => $student,
            'internshipOffer' => $offer
        ]);
        
        if ($existingApplication) {
            $this->addFlash('warning', 'You have already applied to this offer.');
            return $this->redirectToRoute('app_student_offer_details', ['id' => $offer->getId()]);
        }
        
        $application = new Application();
        $application->setStudent($student);
        $application->setInternshipOffer($offer);
        $application->setStatus('pending');
        
        $entityManager->persist($application);
        $entityManager->flush();
        
        $this->addFlash('success', 'Your application has been submitted.');
        return $this->redirectToRoute('app_student_offers');
    }

    #[Route('/my-applications', name: 'app_student_applications')]
    public function myApplications(EntityManagerInterface $entityManager): Response
    {
        $student = $this->getUser();
        $applications = $entityManager->getRepository(Application::class)->findBy(['student' => $student]);
        
        return $this->render('student/my_applications.html.twig', [
            'applications' => $applications
        ]);
    }
}
