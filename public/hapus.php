<?php
// Memulai session dan memuat koneksi database
session_start();
require_once '../config/db.php';

// TODO: Tambahkan pengecekan hak akses/role di sini nanti.
// Misalnya, hanya admin yang boleh menghapus.

// Cek apakah 'id' ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Siapkan query DELETE menggunakan prepared statement untuk keamanan
    $sql = "DELETE FROM products WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter 'id' ke statement
        // "i" berarti tipenya adalah integer
        $stmt->bind_param("i", $id);

        // Eksekusi statement
        if ($stmt->execute()) {
            // Jika berhasil, redirect kembali ke halaman produk dengan pesan sukses
            header("Location: produk.php?status=sukses_hapus");
            $stmt->close();
            exit();
        } else {
            // Jika gagal, redirect dengan pesan error
            header("Location: produk.php?status=gagal_hapus");
            $stmt->close();
            exit();
        }
    }
} else {
    // Jika tidak ada 'id' di URL, redirect ke halaman produk
    header("Location: produk.php");
    exit();
}

// Tutup koneksi
$conn->close();
?>