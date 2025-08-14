<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'barangaej';

// Buat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(['error' => 'Koneksi database gagal: ' . $conn->connect_error]));
}
?>
