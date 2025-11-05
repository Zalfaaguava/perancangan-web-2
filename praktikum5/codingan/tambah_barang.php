<?php
include "koneksi.php";

// Fungsi ambil data kategori
function getKategori($koneksi) {
    $result = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
    if (!$result) {
        die("Query kategori error: " . mysqli_error($koneksi));
    }
    return $result;
}

// Fungsi ambil data supplier
function getSupplier($koneksi) {
    $result = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");
    if (!$result) {
        die("Query supplier error: " . mysqli_error($koneksi));
    }
    return $result;
}

// Proses simpan data
if (isset($_POST['simpan'])) {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $id_supplier = mysqli_real_escape_string($koneksi, $_POST['id_supplier']);
    $satuan = mysqli_real_escape_string($koneksi, $_POST['satuan']);

    if ($nama_barang == "" || $id_kategori == "" || $id_supplier == "" || $satuan == "") {
        $error = "Semua field wajib diisi.";
    } else {
        $query = "INSERT INTO barang (id_kategori, id_supplier, nama_barang, satuan) VALUES ('$id_kategori', '$id_supplier', '$nama_barang', '$satuan')";
        $simpan = mysqli_query($koneksi, $query);
        if ($simpan) {
            echo "<script>alert('Data barang berhasil ditambahkan'); window.location='barang.php';</script>";
            exit;
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    }
}

// Ambil data kategori dan supplier
$kategori = getKategori($koneksi);
$supplier = getSupplier($koneksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Barang - Warung Sembako</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 20px;
}
h2 {
    color: #ff7f00;
}
form {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    width: 350px;
}
label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}
input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    margin-top: 15px;
    background: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}
button:hover {
    background: #218838;
}
a {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
    color: #007bff;
}
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin-top: 15px;
    border-radius: 5px;
}
</style>
</head>
<body>

<h2>➕ Tambah Barang</h2>

<?php
if (!empty($error)) {
    echo "<div class='error'>$error</div>";
}
?>

<form method="POST" action="">
    <label>Nama Barang</label>
    <input type="text" name="nama_barang" required>

    <label>Kategori</label>
    <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        if (mysqli_num_rows($kategori) > 0) {
            while ($row = mysqli_fetch_assoc($kategori)) {
                echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
            }
        } else {
            echo "<option disabled>Belum ada data kategori</option>";
        }
        ?>
    </select>

    <label>Supplier</label>
    <select name="id_supplier" required>
        <option value="">-- Pilih Supplier --</option>
        <?php
        if (mysqli_num_rows($supplier) > 0) {
            while ($row = mysqli_fetch_assoc($supplier)) {
                echo "<option value='{$row['id_supplier']}'>{$row['nama_supplier']}</option>";
            }
        } else {
            echo "<option disabled>Belum ada data supplier</option>";
        }
        ?>
    </select>

    <label>Satuan</label>
    <input type="text" name="satuan" placeholder="Contoh: pcs, kg, liter" required>

    <button type="submit" name="simpan">Simpan Data</button>
</form>

<a href="barang.php">⬅ Kembali ke Data Barang</a>

</body>
</html>
