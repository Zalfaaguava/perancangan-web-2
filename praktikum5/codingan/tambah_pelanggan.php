<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Pelanggan - Warung Sembako</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
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
    width: 400px;
    background: #fff;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 25px 30px;
}

h2 {
    color: #ff7f00;
    text-align: center;
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    display: block;
    margin-top: 10px;
}

input[type="text"], input[type="tel"] {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

button {
    width: 100%;
    background: #28a745;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}
button:hover { background: #218838; }

a.kembali {
    display: inline-block;
    margin-top: 15px;
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
}
a.kembali:hover { text-decoration: underline; }
</style>
</head>
<body>

<header>🛒 Warung Sembako - Tambah Pelanggan</header>

<div class="container">
    <h2>➕ Tambah Pelanggan</h2>

    <form action="" method="POST">
        <label>Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" placeholder="Masukkan nama pelanggan" required>

        <label>Telepon</label>
        <input type="tel" name="telepon" placeholder="Contoh: 081234567890" required>

        <button type="submit" name="simpan">Simpan Data</button>
    </form>

    <a href="pelanggan.php" class="kembali">⬅ Kembali ke Data Pelanggan</a>

    <?php
    if(isset($_POST['simpan'])){
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
        $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon']);

        $simpan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan, telepon)
                                          VALUES ('$nama', '$telepon')");
        if($simpan){
            echo "<script>
                    alert('✅ Pelanggan berhasil ditambahkan!');
                    window.location='pelanggan.php';
                  </script>";
        } else {
            echo "<script>alert('❌ Gagal menambahkan pelanggan.');</script>";
        }
    }
    ?>
</div>

</body>
</html>
