<?php
ob_start(); 
require_once '../functions.php';
require_roles(['pimpinan']);

$from = isset($_GET['from']) ? $_GET['from'] : date('Y-m-01');
$to   = isset($_GET['to'])   ? $_GET['to']   : date('Y-m-d');

// Stok Masuk
$masuk = mysqli_query($conn, "
    SELECT sm.*, b.nama_barang 
    FROM stok_masuk sm 
    JOIN barang b ON sm.id_barang = b.id 
    WHERE DATE(sm.tanggal) BETWEEN '$from' AND '$to'
    ORDER BY sm.tanggal DESC
");

// Stok Keluar
$keluar = mysqli_query($conn, "
    SELECT sk.*, b.nama_barang 
    FROM stok_keluar sk 
    JOIN barang b ON sk.id_barang = b.id 
    WHERE DATE(sk.tanggal) BETWEEN '$from' AND '$to'
    ORDER BY sk.tanggal DESC
");

// Kategori
$kategori = mysqli_query($conn, "
    SELECT k.nama_kategori, COUNT(b.id) AS total
    FROM kategori k
    LEFT JOIN barang b ON b.id_kategori = k.id
    GROUP BY k.id
");

// Supplier
$supplier = mysqli_query($conn, "
    SELECT s.nama_supplier, COUNT(b.id) AS total
    FROM supplier s
    LEFT JOIN barang b ON b.id_supplier = s.id
    GROUP BY s.id
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Stok</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.page-header {
    background: #0d6efd;
    color: white;
    padding: 18px;
    border-radius: 10px;
    margin-bottom: 20px;
}
.card-stat {
    border-left: 6px solid #0d6efd;
    border-radius: 12px;
    padding: 18px;
    background: #f8f9fa;
}
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .table-striped>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #f2f2f2 !important;
    }
}
</style>

</head>
<body>

<div class="container mt-4">

  <div class="page-header shadow-sm">
    <h3 class="mb-0 fw-bold">📄 Laporan Stok Barang</h3>
    <small>Periode: <?= $from ?> sampai <?= $to ?></small>
  </div>

  <div class="d-flex gap-2 mb-3 no-print">
    <a href="index.php" class="btn btn-secondary">← Back</a>
  </div>

  <form class="row g-2 mb-3 no-print">
    <div class="col-md-3">
      <label>Dari Tanggal</label>
      <input type="date" name="from" class="form-control" value="<?= $from ?>">
    </div>
    <div class="col-md-3">
      <label>Sampai Tanggal</label>
      <input type="date" name="to" class="form-control" value="<?= $to ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button class="btn btn-primary w-100">Filter</button>
    </div>
    <a href="send_laporan.php?from=<?= $from ?>&to=<?= $to ?>" class="btn btn-primary">📩 Kirim & Unduh PDF</a>
  </form>

  <!-- ===================== STOK MASUK ===================== -->
  <h4 class="mt-4 fw-bold">📥 Stok Masuk</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered mt-2">
      <thead class="table-dark">
        <tr>
          <th>Tanggal</th>
          <th>Barang</th>
          <th>Jumlah</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = mysqli_fetch_assoc($masuk)): ?>
        <tr>
          <td><?= $r['tanggal'] ?></td>
          <td><?= esc($r['nama_barang']) ?></td>
          <td><?= $r['jumlah'] ?></td>
          <td><?= esc($r['keterangan']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- ===================== STOK KELUAR ===================== -->
  <h4 class="mt-4 fw-bold">📤 Stok Keluar</h4>
  <div class="table-responsive">
    <table class="table table-striped table-bordered mt-2">
      <thead class="table-dark">
        <tr>
          <th>Tanggal</th>
          <th>Barang</th>
          <th>Jumlah</th>
          <th>Tujuan</th>
        </tr>
      </thead>
      <tbody>
        <?php while($r = mysqli_fetch_assoc($keluar)): ?>
        <tr>
          <td><?= $r['tanggal'] ?></td>
          <td><?= esc($r['nama_barang']) ?></td>
          <td><?= $r['jumlah'] ?></td>
          <td><?= esc($r['tujuan']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- ===================== TABEL KATEGORI ===================== -->
  <h4 class="mt-5 fw-bold">📂 Rekap Barang per Kategori</h4>
  <div class="table-responsive">
    <table class="table table-bordered table-striped mt-2">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Kategori</th>
          <th>Total Barang</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while($k = mysqli_fetch_assoc($kategori)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= esc($k['nama_kategori']) ?></td>
          <td><?= $k['total'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- ===================== TABEL SUPPLIER ===================== -->
  <h4 class="mt-5 fw-bold">🏭 Rekap Barang per Supplier</h4>
  <div class="table-responsive mb-5">
    <table class="table table-bordered table-striped mt-2">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Supplier</th>
          <th>Total Barang</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while($s = mysqli_fetch_assoc($supplier)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= esc($s['nama_supplier']) ?></td>
          <td><?= $s['total'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
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