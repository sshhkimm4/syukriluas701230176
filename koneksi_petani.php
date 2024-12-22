<?php
$host = "localhost";      // Nama host server
$user = "root";           // Username MySQL
$password = "";           // Password MySQL
$database = "petanidigital"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
