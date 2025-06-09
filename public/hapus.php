<?php
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$id = $_GET['id'];

// Cek apakah produk ada
$cek = $conn->prepare("SELECT * FROM products WHERE id = ?");
$cek->bind_param("i", $id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows < 1) {
    die("Produk tidak ditemukan.");
}

// Lanjut hapus
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: produk.php?msg=deleted");
} else {
    echo "Gagal menghapus produk: " . $stmt->error;
}
