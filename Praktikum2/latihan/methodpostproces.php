<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data</title>
</head>
<body>
    <h2>Form Input Data Mahasiswa</h2>
    <form action="proses.php" method="POST">
        <label for="nama">Nama Lengkap:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>
        
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim" required><br><br>
        
        <label for="jurusan">Jurusan:</label><br>
        <input type="text" id="jurusan" name="jurusan" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <input type="submit" value="Kirim Data">
        <input type="reset" value="Reset">
    </form>
</body>
</html>