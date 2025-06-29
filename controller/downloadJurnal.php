<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil ID jurnal
$id = $_GET['id'] ?? 0;
if (!$id) {
  die("ID jurnal tidak valid.");
}

// Mulai output buffering untuk menangkap HTML
ob_start();
include 'jurnalPDFView.php'; // pastikan file ini bisa diakses dan isi HTML sesuai
$html = ob_get_clean();

// Setup DomPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output ke browser
$dompdf->stream("jurnal_$id.pdf", ["Attachment" => 1]); // Attachment: 1 = download, 0 = view inline
exit;
