<?php
session_start();

// Jika pengguna tidak login, arahkan ke halaman login (index.html)
if (!isset($_SESSION["username"])) {
    header("location: index.html");
    exit;
}

// Fungsi untuk memeriksa apakah peran pengguna diizinkan mengakses halaman
function check_role($allowed_roles) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        // Jika peran tidak diizinkan, tampilkan pesan error dan hentikan eksekusi
        http_response_code(403); // Kode 'Forbidden'
        echo "<h1 style='text-align:center; margin-top: 5rem;'>Akses Ditolak!</h1>";
        echo "<p style='text-align:center;'>Anda tidak memiliki izin untuk mengakses halaman ini.</p>";
        echo "<p style='text-align:center;'><a href='javascript:history.back()'>Kembali</a> atau <a href='index.html'>Login Ulang</a></p>";
        exit;
    }
}
?>