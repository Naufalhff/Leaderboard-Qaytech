<?php
$server = "localhost"; // nama server
$username = "root"; // username 
$password = ""; // password standar kosong
$database = "qaytech"; // nama database 

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>