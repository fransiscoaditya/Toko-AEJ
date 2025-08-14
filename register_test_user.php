<?php
include 'dbconfig.php'; // Pastikan path ini benar

$username = 'admin';
$password = 'admin123'; // Password yang ingin Anda gunakan

// Hash password dengan aman
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Masukkan ke database
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "User 'admin' berhasil dibuat!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>