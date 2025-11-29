<?php
include "config.php";

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Folder upload
    if(!is_dir("uploads")){
        mkdir("uploads");
    }

    move_uploaded_file($tmp, "uploads/".$gambar);

    mysqli_query($conn, "INSERT INTO barang(nama,harga,keterangan,gambar)
                         VALUES('$nama','$harga','$keterangan','$gambar')");

    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Barang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #5A60FF, #4CC3FF);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Poppins", sans-serif;
}

.card-custom {
    width: 500px;
    background: #fff;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 0 25px rgba(0,0,0,0.2);
}

.card-custom h3 {
    text-align: center;
    font-weight: 600;
    margin-bottom: 15px;
}

.preview-img {
    width: 100%;
    border-radius: 12px;
    margin-top: 10px;
    display: none;
}
</style>
</head>
<body>

<div class="card-custom">
    <h3>Tambah Barang</h3>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input name="nama" class="form-control" placeholder="Masukkan nama barang..." required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input name="harga" type="number" class="form-control" placeholder="Masukkan harga..." required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan barang..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Barang</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required onchange="previewImage()">
            <img id="preview" class="preview-img">
        </div>

        <button name="simpan" class="btn btn-success w-100 mt-3">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
    </form>
</div>

<script>
function previewImage() {
    const file = document.getElementById("gambar").files[0];
    const preview = document.getElementById("preview");

    if (file) {
        preview.style.display = "block";
        preview.src = URL.createObjectURL(file);
    }
}
</script>

</body>
</html>
