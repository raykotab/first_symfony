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

class TransactionController extends AbstractController
{
    #[Route('/upload', name: 'upload_transactions', methods: ['POST'])]
    public function uploadTransactions(Request $request, TransactionService $transactionService): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('csv_file');

        if (!$file) {
            // No file uploaded, return JSON response with error message
            return new JsonResponse(['error' => 'No file uploaded'], Response::HTTP_BAD_REQUEST);
        }

        // Process the CSV file
        $groupedTransactions = $transactionService->processCsv($file);

        // Redirect back to the upload form with a success message
        $this->addFlash('success', 'File uploaded successfully!');
        return $this->redirectToRoute('upload_form_route_name');
    }
}
