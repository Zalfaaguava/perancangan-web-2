<?php
include "koneksi.php";
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pelanggan</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f8f9fa;
    margin: 0;
}
header {
    background-color: #ff7f00;
    color: white;
    padding: 15px 25px;
    font-size: 22px;
    font-weight: bold;
}
.container {
    width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
label { font-weight: bold; display: block; margin-top: 10px; }
input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px; margin-top: 5px; }
button {
    background: #ffc107;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    margin-top: 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
button:hover { background: #e0a800; }
a.kembali {
    color: #007bff;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}
</style>
</head>
<body>

<header>✏️ Edit Pelanggan</header>

<div class="container">
<form action="" method="POST">
    <label>Nama Pelanggan</label>
    <input type="text" name="nama_pelanggan" value="<?= $d['nama_pelanggan']; ?>" required>

    <label>Telepon</label>
    <input type="text" name="telepon" value="<?= $d['telepon']; ?>" required>

    <button type="submit" name="update">Simpan Perubahan</button>
</form>

<a href="pelanggan.php" class="kembali">⬅ Kembali ke Data Pelanggan</a>

<?php
if(isset($_POST['update'])){
    $nama = $_POST['nama_pelanggan'];
    $telepon = $_POST['telepon'];

    $update = mysqli_query($koneksi, "UPDATE pelanggan SET 
                nama_pelanggan='$nama', telepon='$telepon' 
                WHERE id_pelanggan='$id'");
    if($update){
        echo "<script>alert('✅ Data pelanggan berhasil diupdate!'); window.location='pelanggan.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal mengupdate data!');</script>";
    }
}
?>
</div>
</body>
</html>
