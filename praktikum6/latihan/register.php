<?php
include 'config.php'; 

if (!$conn) {
    die("Koneksi database belum tersedia.");
}

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        echo "<script>alert('Password harus minimal 8 karakter, mengandung huruf besar, kecil, angka, dan simbol!'); window.history.back();</script>";
        exit;
    }

    if ($username == "" || $password == "") {
        echo "<script>alert('Input tidak boleh kosong'); window.history.back();</script>";
        exit;
    }

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah digunakan'); window.history.back();</script>";
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($conn, "INSERT INTO users(username, password) VALUES('$username', '$hash')");

    if ($query) {
        echo "<script>alert('Registrasi berhasil'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal registrasi');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register Akun</title>

<style>
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#1a73e8,#4cc3ff);
    font-family: 'Poppins', sans-serif;
}

.card{
    width:380px;
    padding:30px;
    border-radius:20px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(14px);
    border:1px solid rgba(255,255,255,0.3);
    box-shadow: 0 0 25px rgba(255,255,255,0.25),
                0 0 40px rgba(0,0,0,0.2);
    animation: fadeIn .7s ease-in-out;
}

@keyframes fadeIn {
    from { opacity:0; transform:translateY(20px); }
    to { opacity:1; transform:translateY(0); }
}

h2{
    text-align:center;
    font-weight:600;
    margin-bottom:20px;
    color:white;
    text-shadow: 0 0 10px rgba(255,255,255,0.7);
}

label{
    color:white;
    font-size:14px;
}

.input-group{
    margin-bottom:16px;
    position:relative;
}

input{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    background: rgba(255,255,255,0.35);
    color:#fff;
    outline:none;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
}

input::placeholder{
    color:#eee;
}

.show-pass{
    position:absolute;
    right:12px;
    top:52%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#e6e6e6;
    font-size:20px;
}

.strength-bar{
    width:100%;
    height:8px;
    background:#ddd;
    border-radius:5px;
    margin-top:6px;
    overflow:hidden;
}

.strength-fill{
    height:100%;
    width:0%;
    transition:0.3s;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:15px;
    background: linear-gradient(135deg,#00d0ff,#0077ff);
    color:white;
    font-size:16px;
    font-weight:600;
    box-shadow:0 0 15px rgba(0,235,255,0.7);
    cursor:pointer;
    transition:0.25s;
}

button:hover{
    transform: scale(1.06);
    box-shadow:0 0 20px cyan;
}

.login-link{
    text-align:center;
    margin-top:12px;
    color:white;
    font-size:14px;
}

.login-link a{
    color:#fff;
    font-weight:600;
}
</style>
</head>
<body>

<div class="card">
    <h2>Register</h2>

    <form method="POST">

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Buat username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" id="password" name="password" required onkeyup="checkStrength()" placeholder="Minimal 8 karakter">
            <span class="show-pass" onclick="togglePassword()">👁</span>

            <div class="strength-bar">
                <div class="strength-fill" id="strengthFill"></div>
            </div>

            <small id="strengthText" style="font-size:13px; color:#eee;"></small>
        </div>

        <button type="submit" name="register">Daftar</button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="index.php">Login</a>
    </div>
</div>

<script>
function togglePassword(){
    let p = document.getElementById("password");
    p.type = p.type === "password" ? "text" : "password";
}

function checkStrength(){
    let pass = document.getElementById("password").value;
    let fill = document.getElementById("strengthFill");
    let text = document.getElementById("strengthText");

    let score = 0;

    if (pass.length >= 8) score++;
    if (/[a-z]/.test(pass)) score++;
    if (/[A-Z]/.test(pass)) score++;
    if (/\d/.test(pass)) score++;
    if (/[\W_]/.test(pass)) score++;

    if (score <= 2){
        fill.style.width = "30%";
        fill.style.background = "red";
        text.innerHTML = "Weak";
        text.style.color = "red";
    }
    else if (score == 3 || score == 4){
        fill.style.width = "60%";
        fill.style.background = "orange";
        text.innerHTML = "Medium";
        text.style.color = "orange";
    }
    else if (score == 5){
        fill.style.width = "100%";
        fill.style.background = "green";
        text.innerHTML = "Strong";
        text.style.color = "green";
    }
}
</script>

</body>
</html>
