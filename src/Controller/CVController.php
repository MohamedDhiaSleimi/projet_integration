<?php

namespace App\Controller;

use App\Entity\CV;
use App\Entity\Student;
use App\Form\CVType;
use App\Repository\CVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cv')]
class CVController extends AbstractController
{
    #[Route('/', name: 'app_cv_index', methods: ['GET'])]
    #[IsGranted('ROLE_STUDENT')]
    public function index(): Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        $cvs = $student->getCvs();

        return $this->render('cv/index.html.twig', [
            'cvs' => $cvs,
        ]);
    }

    #[Route('/new', name: 'app_cv_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STUDENT')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Student $student */
        $student = $this->getUser();
        $cv = new CV();
        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cv->setStudent($student);
            $entityManager->persist($cv);
            $entityManager->flush();

            $this->addFlash('success', 'CV created successfully.');
            return $this->redirectToRoute('app_cv_index');
        }

        return $this->render('cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cv_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STUDENT')]
    public function edit(Request $request, CV $cv, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'CV updated successfully.');
            return $this->redirectToRoute('app_cv_index');
        }

        return $this->render('cv/edit.html.twig', [
            'cv' => $cv,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_cv_delete', methods: ['POST'])]
    #[IsGranted('ROLE_STUDENT')]
    public function delete(Request $request, CV $cv, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cv_index');
    }

    #[Route('/view/{id}', name: 'app_cv_view', methods: ['GET'])]
    #[IsGranted('ROLE_COMPANY')]
    public function view(CV $cv): Response
    {
        return $this->render('cv/view.html.twig', [
            'cv' => $cv,
        ]);
    }
} 