<?php
ob_start();
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
require_once "controller.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style1.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background:  #000;
        }
        .wrapper {
            position: relative;
            width: 500px;
            height: 500px;
            background: black;
            box-shadow: 0 0 50px cyan;
            border-radius: 20px;
            padding: 50px;
        }
        .wrapper:hover {
            animation: animate 1s linear infinite;
        }
        @keyframes animate {
            100% {
                filter: hue-rotate(360deg);
            }
        }
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 325px;
            height: 325px;
        }
        h2 {
            font-size: 30px;
            text-align: center;
            color: white;
        }
        .input-group {
            position: relative;
            margin: 30px 0;
            border-bottom: 2px solid #fff;
        }
        .input-group label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #fff;
            pointer-events: none;
        }
        .input-group input {
            width: 320px;
            height: 40px;
            font-size: 16px;
            color: #fff;
            padding: 0 5px;
            background: transparent;
            border: none;
            outline: none;
            transition: .5s;
        }
        .input-group input:focus~label,
        .input-group input:valid~label {
            top: -5px;
        }
        .remember {
            margin: -5px 0 15px 5px;
        }
        .remember label {
            color: #fff;
            font-size: 14px;
        }
        .form-btn input{
            position: relative;
            width: 100%;
            height: 40px;
            background: cyan;
            box-shadow: 0 0 10px cyan;
            font-size: 16px
            color: #000;
            font-weight: 500;
            cursor: pointer;
            border-radius: 30px;
            border: none;
            outline: none;
        }
        .forgot-link {
            font-size: 14px;
            text-align: center;
            margin: 15px 0;
        }
        .forgot-link p {
            color: white;
        }
        .forgot-link p a {
            text-decoration: underline;
        }
        .singup-link {
            font-size: 14px;
            text-align: center;
            margin: 15px 0;
        }
        .singup-link p {
            color: white;
        }
        .singup-link p a {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           $loginResult = loginUser($email, $password);
           if (is_string($loginResult)) {
               echo $loginResult;
           }
        }
        ob_end_flush();
        ?>
      <div  class="form-wrapper sing in">
        <form action="login.php" method="post">
        <h2>Login</h2>
        <div class="input-group">
            <input type="email" name="email" >
            <label for="">Email</label>
        </div>      
        <div class="input-group">
            <input type="password" name="password" id="password">
            <label for="">Password</label>
        </div>
        <div class="remember">
            <label for=""><input type="checkbox"> Remember me</label>
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
        <div class="forgot-link">
            <p>Esqueceu sua senha? <a href="forgot_password.php">Recuperar Senha</a></p>
        </div>
        <div class="singup-link">
            <p>Don't have an account? <a href="registration.php">Sing Up</a></p>
        </div>
      </form>
    </div>
    <script>
        function showPassword() {
            var checkbox = document.getElementById("showPassword");
            var password = document.getElementById("password");

            if (checkbox.checked) {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }

    </script>
</body>
</html>