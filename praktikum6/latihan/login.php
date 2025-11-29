<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body{
            margin: 0;
            font-family: Segoe UI, sans-serif;
            background: #f5f5f5;
        }
        .container{
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box{
            width: 360px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 7px 20px rgba(0,0,0,0.1);
            border-top: 6px solid #ff9800;
        }
        h2{
            margin-top: 0;
            color: #ff9800;
            text-align: center;
        }
        input{
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }
        button{
            width: 100%;
            padding: 12px;
            background: #ff9800;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover{
            background: #e68900;
        }
        .register{
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }
        .register a{
            color: #ff9800;
            text-decoration: none;
            font-weight: bold;
        }
        .register a:hover{
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="box">
        <h2>Login</h2>

        <!-- TANPA PESAN ERROR / SUCCESS -->

        <form action="proses_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <div class="register">
            Belum punya akun?  
            <a href="register.php">Registrasi di sini</a>
        </div>

    </div>
</div>

</body>
</html>
