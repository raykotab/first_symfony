<?php
namespace App\Service;
// Suponiendo que ya tienes una entidad Transaction creada

use App\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TransactionService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function processCsv(UploadedFile $file)
    {
        $csvData = array_map('str_getcsv', file($file->getPathname()));
        $transactions = [];
        var_dump($csvData);
        foreach ($csvData as $row) {
            // Suponiendo que la estructura del CSV es: fecha_operacion, concepto, importe, saldo
            $transaction = new Transaction();
            $transaction->setFechaOperacion(new \DateTime($row[0]));
            $transaction->setConcepto($row[1]);
            $transaction->setImporte($row[2]);
            $transaction->setSaldo($row[3]);

            $this->entityManager->persist($transaction);
            $transactions[] = $transaction;
        }

        $this->entityManager->flush();

        return $this->groupByConcept($transactions);
    }

    private function groupByConcept(array $transactions)
    {
        $groupedTransactions = [];

        foreach ($transactions as $transaction) {
            $concept = $transaction->getConcepto();
            $amount = $transaction->getImporte();
            if (!isset($groupedTransactions[$concept])) {
                $groupedTransactions[$concept] = [];
            }
            $groupedTransactions[$concept][] = $transaction;
        }

        return $groupedTransactions;
    }
}
