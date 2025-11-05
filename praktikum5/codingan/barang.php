<?php
// menampilkan error agar mudah cek kesalahan
error_reporting(E_ALL);
ini_set("display_errors", 1);

// include koneksi
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Data Barang - Warung Sembako</title>
<style>
body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
th { background: orange; color: white; }
a { text-decoration: none; background: green; padding: 8px 12px; color: white; border-radius: 5px; }
</style>
</head>
<body>

<h2>📦 Data Barang</h2>
<a href="index.php">⬅ Kembali ke Dashboard</a>
<a href="tambah_barang.php" style="
    text-decoration:none;
    background:#007bff;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    margin-left:10px;
">➕ Tambah Barang</a>

<table>
    <tr>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Harga</th>
    </tr>

    <?php
    $query = mysqli_query($koneksi, "SELECT barang.*, kategori.nama_kategori 
                                    FROM barang 
                                    LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori");

    while($data = mysqli_fetch_array($query)){
        echo "<tr>
                <td>{$data['kode_barang']}</td>
                <td>{$data['nama_barang']}</td>
                <td>{$data['nama_kategori']}</td>
                <td>{$data['stok']}</td>
                <td>Rp ".number_format($data['harga'],0,',','.')."</td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
