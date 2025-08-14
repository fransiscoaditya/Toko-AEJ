<?php
// Letakkan ini di baris paling atas!
include 'php/auth_check.php';
check_role(['admin']); // Hanya peran 'admin' yang boleh mengakses halaman ini
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">Admin <span>Panel</span></a>
        <div class="navbar-extra">
            <span style="color:white; margin-right: 1rem;">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="php/LogoutProcess.php" style="color:white;">Logout</a>
        </div>
    </nav>

    <main style="padding: 8rem 7%; color: white;">
        <h1>Selamat Datang di Dashboard Admin</h1>
        <p>Halaman ini hanya bisa diakses oleh Admin.</p>
    </main>
</body>
</html>