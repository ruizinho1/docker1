<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
} else {
   header("Location: http://localhost:8080/"); // Redireciona para o seu framework Yii
}
?>
