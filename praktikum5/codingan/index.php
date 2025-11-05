<?php
session_start();
$_SESSION['user'] = "Admin"; // sementara
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard | Sistem Penjualan Warung Sembako</title>
<style>
    * {
        margin:0;
        padding:0;
        font-family: "Segoe UI", Arial;
    }

    body {
        background:#f9f9f9;
    }

    .header {
        background:#ff9800;
        padding:15px 20px;
        color:#fff;
        font-size:18px;
        font-weight:bold;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-bottom:3px solid #e57f00;
    }

    .sidebar {
        width:230px;
        background:#ffffff;
        height:100vh;
        border-right:2px solid #eee;
        position:fixed;
        padding:20px;
    }

    .sidebar h2 {
        color:#ff9800;
        font-size:18px;
        margin-bottom:15px;
        border-bottom:2px solid #ff9800;
        padding-bottom:5px;
    }

    .sidebar b {
        display:block;
        margin-top:15px;
        font-size:14px;
        color:#555;
        text-transform:uppercase;
    }

    .sidebar a {
        display:block;
        padding:10px;
        font-size:14px;
        text-decoration:none;
        color:#333;
        border-radius:6px;
        margin-top:5px;
    }

    .sidebar a:hover {
        background:#ffe9c7;
        color:#000;
        font-weight:bold;
    }

    .content {
        margin-left:250px;
        padding:25px;
    }

    .card-wrapper {
        display:flex;
        gap:20px;
        margin-top:20px;
    }

    .card {
        flex:1;
        background:#fff;
        padding:20px;
        border-radius:10px;
        border:1px solid #ddd;
        text-align:center;
        box-shadow:0 2px 5px rgba(0,0,0,0.08);
    }

    .card h3 {
        color:#555;
        margin-bottom:10px;
    }

    .card p {
        font-size:22px;
        font-weight:bold;
        color:#ff9800;
    }
</style>
</head>
<body>

<!-- Header -->
<div class="header">
    Sistem Informasi Penjualan Warung Sembako
    <div style="font-size:14px; font-weight:normal;">
        User: <b><?php echo $_SESSION['user']; ?></b> |
        <a href="#" style="color:white; text-decoration:none;">Logout</a>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Menu Utama</h2>

    <a href="index.php">🏠 Dashboard</a>

    <b>Data Master</b>
    <a href="barang.php">📦 Barang</a>
    <a href="kategori.php">🗂️ Kategori</a>
    <a href="supplier.php">🚚 Supplier</a>
    <a href="pelanggan.php">👥 Pelanggan</a>
    <a href="user.php">👤 User</a>

    <b>Transaksi</b>
    <a href="penjualan.php">🛒 Penjualan</a>
    <a href="pembelian.php">📥 Pembelian</a>

    <b>Laporan</b>
    <a href="laporan_penjualan.php">📊 Laporan Penjualan</a>
    <a href="laporan_pembelian.php">📑 Laporan Pembelian</a>
    <a href="laporan_stok.php">📦 Laporan Stok</a>
</div>

<!-- Content -->
<div class="content">
    <h2>Selamat Datang 👋</h2>
    <p>Sistem Manajemen Penjualan & Stok Barang Warung Sembako</p>

    <div class="card-wrapper">
        <div class="card">
            <h3>Total Barang</h3>
            <p>150 Item</p>
        </div>
        <div class="card">
            <h3>Penjualan Hari Ini</h3>
            <p>Rp 750.000</p>
        </div>
        <div class="card">
            <h3>Pembelian Bulan Ini</h3>
            <p>Rp 2.100.000</p>
        </div>
    </div>
</div>

</body>
</html>
