<?php
session_start(); // Memulai session untuk menyimpan pesan feedback
require_once '../config/config.php';

// Cek apakah ada data yang dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'tambah':
            $nama_produk = $_POST['nama_produk'];
            $id_kategori = $_POST['id_kategori'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $sql = "INSERT INTO produk (nama_produk, id_kategori, harga, stok) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_produk, $id_kategori, $harga, $stok]);

            $_SESSION['pesan'] = "Produk baru berhasil ditambahkan.";
            break;

        case 'edit':
            $id_produk = $_POST['id_produk'];
            $nama_produk = $_POST['nama_produk'];
            $id_kategori = $_POST['id_kategori'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $sql = "UPDATE produk SET nama_produk = ?, id_kategori = ?, harga = ?, stok = ? WHERE id_produk = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama_produk, $id_kategori, $harga, $stok, $id_produk]);

            $_SESSION['pesan'] = "Data produk berhasil diperbarui.";
            break;
    }
}

// Logika untuk menghapus data (via GET)
if (isset($_GET['hapus'])) {
    $id_produk = $_GET['hapus'];

    $sql = "DELETE FROM produk WHERE id_produk = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_produk]);

    $_SESSION['pesan'] = "Produk berhasil dihapus.";
}

// Arahkan kembali ke halaman daftar produk
header("Location: produk_tampil.php");
exit();
