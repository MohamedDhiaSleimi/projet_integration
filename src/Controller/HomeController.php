<?php
// src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        if ($security->isGranted('ROLE_STUDENT')) {
            return $this->redirectToRoute('app_student_dashboard');
        }
        
        if ($security->isGranted('ROLE_COMPANY')) {
            return $this->redirectToRoute('app_company_dashboard');
        }
         if ($security->isGranted('ROLE_SUPERVISOR')) {
            return $this->redirectToRoute('seance_index');
        }
        return $this->render('home/index.html.twig');
    }
}