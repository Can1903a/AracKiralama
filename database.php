<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "arac_kiralama";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}   
?>