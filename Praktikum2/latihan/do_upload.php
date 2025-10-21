<!DOCTYPE html>
<html>
<head>
    <title>Simpan file yang diupload</title>
</head>
<body>
<h1>Simpan file yang diupload</h1>

<?php
// Pastikan folder tujuan upload sudah ada
$target_dir = "uploads/";

// Jika folder belum ada, buat dulu
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Periksa apakah file ada dan tidak error
if (isset($_FILES['file1']) && $_FILES['file1']['error'] == 0) {
    $file_tmp = $_FILES['file1']['tmp_name'];
    $file_name = basename($_FILES['file1']['name']);
    $target_file = $target_dir . $file_name;

    // Pindahkan file dari tmp ke folder tujuan
    if (move_uploaded_file($file_tmp, $target_file)) {
        echo "<p>File <b>$file_name</b> berhasil diupload ke folder <b>$target_dir</b></p>";
    } else {
        echo "<p>Terjadi kesalahan saat menyimpan file.</p>";
    }
} else {
    echo "<p>Tidak ada file yang diupload atau terjadi error.</p>";
}
?>
</body>
</html>
