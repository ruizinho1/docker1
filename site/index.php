<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechTudo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-size: cover;
            background-position: center;
            font-family: sans-serif;
        }
        .menu-bar {
            background: cyan;
            text-align: center;
        }
        .menu-bar ul {
            display: inline-flex;
            list-style: none;
            color: black;
        }
        .menu-bar ul li {
            width: 120px;
            margin: 15px;
            padding: 15px;
        }
        .menu-bar ul li a {
            text-decoration: none;
            color: black;
        }
        .active, .menu-bar ul li:hover {
            background: blue;
            border-radius: 3px;
        }
        .slidebar {
            position: fixed;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #042331;
        }
        .slidebar header {
            font-size: 22px;
            color: white;
            text-align: center;
            line-height: 70px;
            background: #063146;
            user-slect: none;
        }
        .slidebar ul a {
            display: block;
            height: 100%;
            width: 100%;
            line-height: 65px;
            font-size: 20px;
            color: white;
            padding-left: 40px;
            box-sizing: border-box;
            text-decoration: none;
            border-top: 1px solid rgba(255, 255, 255, .1);
            border-bottom: 1px solid black;
        }
        ul li:hover a{
            padding-left: 50px;
        }
        .slidebar ul a i {
            margin-right: 16px;
        }
        #check {
            display: none;
        }
        label #btn, label#cancel {
            position: absolute;
            cursor: pointer;
            background: #042331;
            border-radius: 3px;
        }
        label #btn {
            left: 40px:
            top: 25px;
            font-size: 35px;
            color: white;
            padding: 6px 12px;
        }
        label #cancel {
            z-index: 1111;
            left: -195px;
            top: 17px;
            font-size: 30px;
            color: #0a5275;
            padding: 4px 9px;
            transition: all .5s ease;
        }
        #check:checked ~.slidebar {
            left: 0;
        }
        #check:checked ~ label #btn {
            left: 250px;
            opacity: 0;
            pointer-events: none;
        }
        #check:checked ~ label #cancel {
            left: 195px;
        }
        #check:checked ~ section {
            margin-left: 250px;
        }
        section {
            background: url(img1.jpg) no-repeat;
            background position: center;
            background-size: cover;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="menu-bar">
    <ul>
        <li class="active"><a href="#"><i class="fa fa-home fa-fw"></i>Home</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Feedback</a></li>
        <li><a href="#">Promoções</a></li>
        <li><a href="#">Carrinho</a></li>
        <li><a href="logout.php" class="btn btn-warning logout-btn">Logout</a></li>
    </ul>
    </div>
    <input type="checkbox" id="check">
    <label for="check">
        <i style="font-size:24px" class="fa" id="btn">&#xf03a;</i>
        <i style="font-size:24px" class="fa" id="cancel">&#xf00d;</i>
    </label>
    <div class="slidebar">
        <header>Produtos</header>
        <ul>
            <li><a href="#">Telemóveis</a></li>
            <li><a href="#">Eletrodomésticos</a></li>
            <li><a href="#">Informática</a></li>
            <li><a href="#">Tv e som</a></li>
            <li><a href="#">Gamimg</a></li>
            <li><a href="#">Fotografia, Drones e Vídeo</a></li>
        </ul>
    </div>
    <section></section>
</body>
</html>