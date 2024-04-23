<?php

$hostName = "docker1-db-1";
$dbUser = "root";
$dbPassword = "12345";
$dbName = "docker_database";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>