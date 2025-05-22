<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan jika ada
$dbname = "todo"; // ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>