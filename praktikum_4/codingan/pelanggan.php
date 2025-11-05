<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pelanggan - Warung Sembako</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

header {
    background-color: #ff7f00;
    color: white;
    padding: 15px 25px;
    font-size: 22px;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.container {
    max-width: 900px;
    background: #fff;
    margin: 40px auto;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 25px;
}

h2 {
    color: #ff7f00;
    margin-bottom: 20px;
}

a.btn {
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 600;
    margin-right: 8px;
    color: white;
}

.tambah { background: #28a745; }
.tambah:hover { background: #218838; }
.kembali { background: #007bff; }
.kembali:hover { background: #0056b3; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}
th {
    background-color: #ff7f00;
    color: white;
}
tr:hover {
    background-color: #f1f1f1;
}

/* Tombol aksi */
.action-btn {
    text-decoration: none;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    margin-right: 4px;
    font-size: 13px;
}
.edit { background: #ffc107; }
.edit:hover { background: #e0a800; }
.hapus { background: #dc3545; }
.hapus:hover { background: #c82333; }
</style>
</head>
<body>

<header>🛒 Warung Sembako - Data Pelanggan</header>

<div class="container">
    <h2>📋 Daftar Pelanggan</h2>
    <a href="tambah_pelanggan.php" class="btn tambah">+ Tambah Pelanggan</a>
    <a href="index.php" class="btn kembali">🏠 Kembali ke Dashboard</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>

        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
        while($data = mysqli_fetch_array($query)){
            echo "<tr>
                    <td>{$data['id_pelanggan']}</td>
                    <td>{$data['nama_pelanggan']}</td>
                    <td>{$data['telepon']}</td>
                    <td>
                        <a href='edit_pelanggan.php?id={$data['id_pelanggan']}' class='action-btn edit'>✏️ Edit</a>
                        <a href='hapus_pelanggan.php?id={$data['id_pelanggan']}' 
                           class='action-btn hapus' 
                           onclick=\"return confirm('Yakin ingin menghapus pelanggan ini?');\">🗑️ Hapus</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
