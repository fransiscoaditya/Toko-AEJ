<?php
header('Content-Type: application/json');

// Sertakan koneksi database
include 'dbconfig.php';

// Query ambil data dari tabel barang dan ubah nama kolom
$sql = "SELECT id, nama_barang AS name, gambar AS img, kategori, harga_jual AS price FROM barang";
$result = $conn->query($sql);

// Array penampung produk
$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['price'] = (int)$row['price']; // pastikan harga dalam bentuk angka
        $products[] = $row;
    }
}

$conn->close();

// Keluarkan hasil dalam format JSON
echo json_encode($products);
