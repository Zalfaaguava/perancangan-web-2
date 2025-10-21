<!DOCTYPE html>
<html>
<head>
    <title>Proses Input</title>
</head>
<body>
<?php
// Pastikan data dikirim lewat POST
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
} else {
    $username = "";
    $password = "";
}
?>
<h2>Hasil Input Form Login</h2>
Username : <?php echo $username; ?><br>
Password : <?php echo $password; ?><br>
</body>
</html>
