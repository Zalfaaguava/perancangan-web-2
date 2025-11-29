<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
    body{
        margin: 0;
        font-family: Segoe UI, sans-serif;
        background: #f1f1f1;
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
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 7px 20px rgba(0,0,0,0.1);
        border-top: 6px solid #ff9800;
    }
    h2{
        margin-top: 0;
        font-weight: 600;
        color: #ff9800;
        text-align: center;
    }
    label{
        font-weight: 600;
        font-size: 14px;
    }
    input{
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        margin-top: 5px;
        margin-bottom: 18px;
        font-size: 14px;
    }
    button{
        width: 100%;
        padding: 12px;
        background: #ff9800;
        border: none;
        color: #fff;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }
    .msg{
        text-align:center;
        font-size:14px;
        margin-bottom:15px;
    }
</style>
</head>
<body>

<div class="container">
    <div class="box">
        <h2>Register Akun</h2>

        <!-- Notifikasi -->
        <?php if (isset($_GET['error'])) { ?>
            <p class="msg" style="color:red;"><?= $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="msg" style="color:green;"><?= $_GET['success']; ?></p>
        <?php } ?>

        <form action="proses_register.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="daftar">Daftar</button>
        </form>
    </div>
</div>

</body>
</html>
