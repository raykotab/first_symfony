<?php

namespace App\Controller;

use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TransactionController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    #[Route('/upload', name: 'upload_transactions', methods: ['POST'])]
    public function uploadTransactions(Request $request, TransactionService $transactionService): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('csv_file');

        if (!$file) {
            // No file uploaded, return JSON response with error message
            $this->addFlash('error', 'An error occurred. Please try again.');
            return $this->redirectToRoute('upload_form');
        }

        // Process the CSV file
        $groupedTransactions = $transactionService->processCsv($file);

        // Redirect back to the upload form with a success message
        $this->addFlash('success', 'File uploaded successfully!');
        return $this->redirectToRoute('upload_form_route_name');
    }

    #[Route('/upload-form', name: 'upload_form')]
    public function uploadForm(Request $request): Response
    {
        // Check if there's an error message in the session (e.g., from a failed form submission)
        $error = $request->getFlash()->get('error');

        return $this->render('upload_form.html.twig', [
            'error' => $error
        ]);
    }
}
