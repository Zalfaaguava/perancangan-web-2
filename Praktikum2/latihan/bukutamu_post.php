<html>
<head>
    <title>Buku Tamu</title>
</head>
<body>
<?php
// Supaya tidak error kalau form belum dikirim
$nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$komentar = isset($_POST["komentar"]) ? $_POST["komentar"] : "";
?>
<h1>Data Buku Tamu</h1>
<hr>
Nama anda : <?php echo $nama; ?><br><br>
Email address : <?php echo $email; ?><br><br>
Komentar : <br>
<textarea name="komentar" cols="40" rows="5"><?php echo $komentar; ?></textarea>
<br><br>
<a href="bukutamu.php">Kembali ke Form</a>
</body>
</html>
