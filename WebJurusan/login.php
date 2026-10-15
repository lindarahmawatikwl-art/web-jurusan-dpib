<?php

session_start(); include "koneksi.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM login
                WHERE username='$username'
                AND password= '$password'");

    if (mysqli_num_rows($query) > 0) {

        $_SESSION['admin'] = $username;
        header("location:Dashboard_admin.php?login=succes");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
</head>
<style>
    * {
        box-sizing: border-box;
        font-family: Arial;
    }

    body {
        margin: 0;
        height: 100vh;
        display: grid;
        place-items: center;
        background: #f4f4f6;
    }

    .login-container {
        width: 350px;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px #ddd;
    }
    h2,p{
        text-align: center;
    }
    p {
        color: #777;
    }
    .form-group {
        margin: 15px 0;
    }
    label{
        display: block;
        margin-bottom: 5px ;
    }
    input, .btn-login {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
    }
    input {
        border: 1px solid #ddd;
    }
    .btn-login {
        border: 0;
        background: #222;
        color: white;
        cursor: pointer;
    }
    .error {
        padding: 10px;
        background: #ffe5e5;
        color: red;
        text-align: center;
        border-radius: 8px;
    }
</style>

<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <p>Silahkan masuk ke halaman admin</p>

        <?php if (isset($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukan username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukan password" required>
            </div>


            <button type="submit" name="login" class="btn-login">Login</button>

        </form>
    </div>
</body>

</html>