<?php
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
    <title>Formulário de Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
        .singin-link {
            font-size: 14px;
            text-align: center;
            margin: 15px 0;
        }
        .singin-link p {
            color: white;
        }
        .singin-link p a {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="wrapper">
        <?php
        if (isset($_POST["submit"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           $registerResult = registerUser($email, $password, $passwordRepeat);
           if (is_array($registerResult)) {
               foreach ($registerResult as $error) {
                   echo "<div class='alert alert-danger'>$error</div>";
               }
           } else {
               echo $registerResult;
           }
        }
        ?>
        <div class="form-wrapper sing up">
        <form action="registration.php" method="post">
        <h2>Registration</h2>
            <div class="input-group">
                <input type="email"  name="email" placeholder="Email:">
            </div>
            <div class="input-group">
                <input type="password"  name="password" placeholder="Password:">
            </div>
            <div class="input-group">
                <input type="password" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
            <div class="singin-link">
                <p>Already Registered <a href="login.php">Login Here</a></p>
            </div>
        </form>
    </div>
</body>
</html>