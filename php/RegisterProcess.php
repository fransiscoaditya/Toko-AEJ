<?php
session_start();
header('Content-Type: application/json');

include 'dbconfig.php';

// Mengambil data JSON yang dikirim dari frontend
$data = json_decode(file_get_contents('php://input'), true);

// Menetapkan variabel dari data yang diterima
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Validasi dasar: memastikan tidak ada kolom yang kosong
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua kolom tidak boleh kosong.']);
    exit;
}

// Validasi format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Format email tidak valid.']);
    exit;
}

// Validasi panjang password
if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password minimal harus 6 karakter.']);
    exit;
}

// 1. Cek duplikasi username ATAU email untuk pendaftaran publik
// Ini adalah baris kunci untuk memastikan email unik bagi pendaftar baru
$sql_check = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $username, $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username atau Email ini sudah digunakan.']);
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// 2. Jika aman, hash password dan masukkan user baru dengan peran 'user'
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$default_role = 'user'; // Peran default untuk semua pendaftar baru

$sql_insert = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ssss", $username, $email, $hashed_password, $default_role);

if ($stmt_insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil! Silakan login.']);
} else {
    // Menampilkan error dari database jika ada masalah
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan pada server: ' . $stmt_insert->error]);
}

$stmt_insert->close();
$conn->close();
?>