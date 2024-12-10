<?php
// src/Service/PdfGeneratorService.php
namespace App\Service;
use TCPDF;
class PdfGeneratorService
{
    public function generateCoursPdf(string $coursTitle, string $coursDescription): string
    {
        // Création d'une instance de TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        
        // Titre du PDF
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Course: ' . $coursTitle, 0, 1, 'C');

        // Description du cours
        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 10, 'Description: ' . $coursDescription);

        // Générer le fichier PDF dans un fichier temporaire
        $filePath = '/tmp/' . $coursTitle . '-cours.pdf';
        $pdf->Output($filePath, 'F');  // 'F' pour sauvegarder dans un fichier

        return $filePath;
    }
}
