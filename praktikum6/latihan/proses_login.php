<?php
session_start();
include "koneksi.php";

$user = $_POST['username'];
$pass = $_POST['password'];

// GANTI TABEL user → users
$q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");

if (!$q) {
    die("Query gagal: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($q) == 0) {
    header("Location: login.php?error=Username tidak ditemukan!");
    exit();
}

$data = mysqli_fetch_assoc($q);

// COCOKKAN PASSWORD
if ($data['password'] !== $pass) {
    header("Location: login.php?error=Password salah!");
    exit();
}

// CEK STATUS
if ($data['status'] !== 'aktif') {
    header("Location: login.php?error=Akun tidak aktif!");
    exit();
}

// LOGIN BERHASIL
$_SESSION['user'] = $data['username'];
$_SESSION['role'] = $data['role'];
$_SESSION['nama'] = $data['nama'];

header("Location: index.php");
exit();
?>