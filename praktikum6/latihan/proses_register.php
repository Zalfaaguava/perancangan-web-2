<?php
include "koneksi.php";

if (isset($_POST['daftar'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Cek username sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");

    if (!$cek) {
        die("Query cek gagal: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($cek) > 0) {
        header("Location: register.php?error=Username sudah digunakan!");
        exit();
    }

    // Insert data baru (role default: 'user')
    $insert = mysqli_query($koneksi, 
        "INSERT INTO users (username, password, nama, role, status) 
         VALUES ('$user', '$pass', '$user', 'user', 'aktif')"
    );

    if ($insert) {
        header("Location: register.php?success=Registrasi berhasil! Silakan login.");
        exit();
    } else {
        die("Gagal membuat akun: " . mysqli_error($koneksi));
    }
}
?>
