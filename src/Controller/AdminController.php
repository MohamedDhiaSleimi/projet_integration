<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Company;
use App\Entity\InternshipOffer;
use App\Entity\Student;
use App\Entity\Supervisor;
use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use App\Repository\InternshipOfferRepository;
use App\Repository\StudentRepository;
use App\Repository\SupervisorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function dashboard(
        StudentRepository $studentRepository,
        CompanyRepository $companyRepository,
        SupervisorRepository $supervisorRepository,
        InternshipOfferRepository $offerRepository,
        ApplicationRepository $applicationRepository
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'students_count' => $studentRepository->count([]),
            'companies_count' => $companyRepository->count([]),
            'supervisors_count' => $supervisorRepository->count([]),
            'offers_count' => $offerRepository->count([]),
            'recent_applications' => $applicationRepository->findBy([], ['appliedAt' => 'DESC'], 5),
            'recent_offers' => $offerRepository->findBy([], ['createdAt' => 'DESC'], 5),
        ]);
    }

    #[Route('/students', name: 'app_admin_student_index')]
    public function students(StudentRepository $studentRepository): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    #[Route('/companies', name: 'app_admin_company_index')]
    public function companies(CompanyRepository $companyRepository): Response
    {
        return $this->render('admin/company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/supervisors', name: 'app_admin_supervisor_index')]
    public function supervisors(SupervisorRepository $supervisorRepository): Response
    {
        return $this->render('admin/supervisors.html.twig', [
            'supervisors' => $supervisorRepository->findAll(),
        ]);
    }

    #[Route('/offers', name: 'app_admin_offer_index')]
    public function offers(InternshipOfferRepository $offerRepository): Response
    {
        return $this->render('admin/offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    #[Route('/applications', name: 'app_admin_application_index')]
    public function applications(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('admin/application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
        ]);
    }
} 