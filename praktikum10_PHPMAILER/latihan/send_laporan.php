<?php
require_once '../functions.php';
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ambil parameter tanggal
$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to'] ?? date('Y-m-d');

// Query Stok Masuk
$masuk = mysqli_query($conn, "
    SELECT sm.*, b.nama_barang 
    FROM stok_masuk sm 
    JOIN barang b ON sm.id_barang = b.id 
    WHERE DATE(sm.tanggal) BETWEEN '$from' AND '$to'
    ORDER BY sm.tanggal DESC
");

// Query Stok Keluar
$keluar = mysqli_query($conn, "
    SELECT sk.*, b.nama_barang 
    FROM stok_keluar sk 
    JOIN barang b ON sk.id_barang = b.id 
    WHERE DATE(sk.tanggal) BETWEEN '$from' AND '$to'
    ORDER BY sk.tanggal DESC
");

// Tangkap HTML laporan
ob_start();
?>
<h2>Laporan Stok Barang</h2>
<p>Periode: <?= $from ?> s/d <?= $to ?></p>

<h3>Stok Masuk</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>Tanggal</th><th>Barang</th><th>Jumlah</th><th>Keterangan</th></tr>
<?php while($r = mysqli_fetch_assoc($masuk)): ?>
<tr>
<td><?= $r['tanggal'] ?></td>
<td><?= esc($r['nama_barang']) ?></td>
<td><?= $r['jumlah'] ?></td>
<td><?= esc($r['keterangan']) ?></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Stok Keluar</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>Tanggal</th><th>Barang</th><th>Jumlah</th><th>Tujuan</th></tr>
<?php while($r = mysqli_fetch_assoc($keluar)): ?>
<tr>
<td><?= $r['tanggal'] ?></td>
<td><?= esc($r['nama_barang']) ?></td>
<td><?= $r['jumlah'] ?></td>
<td><?= esc($r['tujuan']) ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php
$html = ob_get_clean();

// =================== GENERATE PDF ===================
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Simpan PDF sementara
$pdfFile = __DIR__ . '/laporan.pdf'; // path absolut supaya aman
file_put_contents($pdfFile, $dompdf->output());

// =================== KIRIM EMAIL ===================
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'toko.sembako.kecil@gmail.com';
    $mail->Password   = '';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('toko.sembako.kecil@gmail.com', 'Toko Sembako Kecil');
    $mail->addAddress('guavarahma@gmail.com');

    $mail->Subject = 'Laporan Stok Barang';
    $mail->Body    = 'Berikut terlampir laporan stok barang.';
    $mail->addAttachment($pdfFile);

    $mail->send();

    echo '<script>alert("Email laporan berhasil dikirim!"); window.location.href="index.php";</script>';

} catch (Exception $e) {
    echo "Email gagal dikirim: {$mail->ErrorInfo}";
}

// Hapus file sementara
if(file_exists($pdfFile)){
    unlink($pdfFile);
}
?>

