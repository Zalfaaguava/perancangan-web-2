<?php
require_once '../functions.php';
require_roles(['pimpinan']);


// ======================= QUERY RINGKASAN =======================

// Total barang
$total_barang = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM barang"))[0];

// Barang hampir habis
$low = mysqli_query($conn, "
    SELECT nama_barang, stok, stok_minimum 
    FROM barang 
    WHERE stok <= stok_minimum
");

// Ambil kategori
$kategori = mysqli_query($conn, "
    SELECT k.nama_kategori, COUNT(b.id) AS total 
    FROM kategori k
    LEFT JOIN barang b ON b.id_kategori = k.id
    GROUP BY k.id
");

// Ambil supplier
$supplier = mysqli_query($conn, "
    SELECT s.nama_supplier, COUNT(b.id) AS total 
    FROM supplier s
    LEFT JOIN barang b ON b.id_supplier = s.id
    GROUP BY s.id
");

// Grafik stok masuk per bulan
$masuk = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, COUNT(*) AS total
    FROM stok_masuk
    GROUP BY bulan
    ORDER BY bulan
");

// Grafik stok keluar per bulan
$keluar = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(jumlah) AS total
    FROM stok_keluar
    GROUP BY bulan
    ORDER BY bulan
");

?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard Pimpinan</title>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.card-summary {
    border-left: 6px solid #0d6efd;
    border-radius: 10px;
    transition: .2s;
}
.card-summary:hover { transform: scale(1.02); }
.table-box { margin-top: 40px; }
</style>
</head>
<body>

<nav class="navbar navbar-dark bg-secondary">
  <div class="container-fluid">
    <span class="navbar-brand fw-bold">Dashboard Pimpinan</span>
    <a class="btn btn-light btn-sm" href="../logout.php">Logout</a>
  </div>
</nav>

<div class="container mt-4">

  <!-- ===================== KARTU RINGKASAN ===================== -->
  <h4 class="mb-3">Ringkasan</h4>
  <div class="row g-3">

    <div class="col-md-4">
      <div class="card card-summary p-3 shadow-sm">
        <h6 class="text-muted">Total Barang</h6>
        <h3 class="fw-bold"><?= $total_barang ?></h3>
      </div>
    </div>

    <div class="col-md-8 d-flex align-items-center">
      <a href="laporan.php" class="btn btn-primary btn-lg w-100">Lihat Laporan & Cetak</a>
    </div>

  </div>


  <!-- =========================== GRAFIK ============================ -->

  <h4 class="mt-5">Grafik Gudang</h4>

  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card p-3 shadow-sm">
        <h6 class="fw-bold">Barang Masuk per Bulan</h6>
        <canvas id="chartMasuk"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3 shadow-sm">
        <h6 class="fw-bold">Barang Keluar per Bulan</h6>
        <canvas id="chartKeluar"></canvas>
      </div>
    </div>
  </div>


  <div class="row mt-3">
    <div class="col-md-6">
      <div class="card p-3 shadow-sm">
        <h6 class="fw-bold">Barang per Kategori</h6>
        <canvas id="chartKategori"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3 shadow-sm">
        <h6 class="fw-bold">Barang per Supplier</h6>
        <canvas id="chartSupplier"></canvas>
      </div>
    </div>
  </div>



  <!-- =================== TABEL BARANG HABIS ==================== -->

  <div class="table-box">
    <h5>Barang Hampir Habis</h5>
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Stok</th>
          <th>Minimum</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=1; while($r=mysqli_fetch_assoc($low)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= esc($r['nama_barang']) ?></td>
          <td><?= $r['stok'] ?></td>
          <td><?= $r['stok_minimum'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>



  <!-- =================== TABEL KATEGORI ==================== -->

  <div class="table-box">
    <h5>Data Kategori</h5>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Kategori</th>
          <th>Total Barang</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=1; while($k=mysqli_fetch_assoc($kategori)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $k['nama_kategori'] ?></td>
          <td><?= $k['total'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>



  <!-- =================== TABEL SUPPLIER ==================== -->

  <div class="table-box">
    <h5>Data Supplier</h5>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Supplier</th>
          <th>Total Barang</th>
        </tr>
      </thead>
      <tbody>
      <?php $i=1; while($s=mysqli_fetch_assoc($supplier)): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $s['nama_supplier'] ?></td>
          <td><?= $s['total'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>


<!-- ======================= SCRIPT GRAFIK ======================= -->
<script>
new Chart(document.getElementById('chartMasuk'), {
    type: 'line',
    data: {
        labels: [<?php while($m=mysqli_fetch_assoc($masuk)) echo "'".$m['bulan']."'," ?>],
        datasets: [{
            label: 'Masuk',
            data: [<?php mysqli_data_seek($masuk,0); while($m=mysqli_fetch_assoc($masuk)) echo $m['total']."," ?>],
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('chartKeluar'), {
    type: 'line',
    data: {
        labels: [<?php while($k=mysqli_fetch_assoc($keluar)) echo "'".$k['bulan']."'," ?>],
        datasets: [{
            label: 'Keluar',
            data: [<?php mysqli_data_seek($keluar,0); while($k=mysqli_fetch_assoc($keluar)) echo $k['total']."," ?>],
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('chartKategori'), {
    type: 'bar',
    data: {
        labels: [<?php mysqli_data_seek($kategori,0); while($k=mysqli_fetch_assoc($kategori)) echo "'".$k['nama_kategori']."'," ?>],
        datasets: [{
            label: 'Jumlah',
            data: [<?php mysqli_data_seek($kategori,0); while($k=mysqli_fetch_assoc($kategori)) echo $k['total']."," ?>],
            borderWidth: 2
        }]
    }
});

new Chart(document.getElementById('chartSupplier'), {
    type: 'bar',
    data: {
        labels: [<?php mysqli_data_seek($supplier,0); while($s=mysqli_fetch_assoc($supplier)) echo "'".$s['nama_supplier']."'," ?>],
        datasets: [{
            label: 'Jumlah',
            data: [<?php mysqli_data_seek($supplier,0); while($s=mysqli_fetch_assoc($supplier)) echo $s['total']."," ?>],
            borderWidth: 2
        }]
    }
});
</script>

</body>
</html>
