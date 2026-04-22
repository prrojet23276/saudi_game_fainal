<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saudi_game";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات");
}
?>