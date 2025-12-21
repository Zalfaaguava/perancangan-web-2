<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$html = ob_get_clean(); // ambil semua HTML yang ditampilkan
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// simpan sementara PDF
$pdfFile = 'laporan.pdf';
file_put_contents($pdfFile, $dompdf->output());

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'toko.semboko.kecil@gmail.com'; // ganti dengan email kamu
    $mail->Password   = 'xilrjzogdruxbgmm';      // ganti dengan password/app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('toko.sembako.kecil@gmail.com', 'Nama Kamu');
    $mail->addAddress('guavarahma@email.com'); // email tujuan

    $mail->Subject = 'Laporan Stok Barang';
    $mail->Body    = 'Berikut terlampir laporan stok barang.';
    $mail->addAttachment($pdfFile);

    $mail->send();
    echo '<script>alert("Email laporan berhasil dikirim!");</script>';
} catch (Exception $e) {
    echo "Email gagal dikirim: {$mail->ErrorInfo}";
}

// hapus file PDF sementara
unlink($pdfFile);

?>