<?php
session_start();

// Hancurkan semua data sesi.
$_SESSION = array();

// Hancurkan sesi.
session_destroy();

// Arahkan ke halaman login
header("location: ../index.html");
exit;
?>