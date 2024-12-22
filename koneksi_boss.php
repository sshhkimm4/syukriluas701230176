<?php
$host = "localhost";     // Nama host database
$user = "root";          // Username MySQL (default: root)
$password = "";          // Password MySQL (default: kosong)
$database = "petanidigital"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
