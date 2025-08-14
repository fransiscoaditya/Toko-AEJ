<?php
session_start();
header('Content-Type: application/json');

include 'dbconfig.php';

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username dan password tidak boleh kosong.']);
    exit;
}

// Ambil juga kolom 'role' dari database
$sql = "SELECT id, username, password, email, role FROM users WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Buat session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Simpan peran ke session

        // Kirim status sukses DAN peran pengguna
        echo json_encode(['status' => 'success', 'role' => $user['role']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username atau password salah.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username atau password salah.']);
}

$stmt->close();
$conn->close();
?>