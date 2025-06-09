<?php
session_start();
require_once '../config/db.php';

// Pastikan hanya admin yang bisa mengakses (contoh)
// if ($_SESSION['role'] !== 'admin') {
//     die("Akses ditolak.");
// }

$id = $_GET['id'] ?? null;

// Redirect jika tidak ada ID
if (!$id) {
    header("Location: supplier.php");
    exit();
}

// 1. Cek apakah supplier ini masih terhubung dengan produk
$sql_check = "SELECT COUNT(*) AS product_count FROM products WHERE supplier_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row = $result_check->fetch_assoc();

if ($row['product_count'] > 0) {
    // Jika masih ada produk terkait, gagalkan penghapusan
    $stmt_check->close();
    $conn->close();
    header("Location: supplier.php?status=gagal_hapus&error=terkait_produk");
    exit();
}
$stmt_check->close();


// 2. Jika tidak ada produk terkait, lanjutkan proses penghapusan
$sql_delete = "DELETE FROM suppliers WHERE id = ?";
if ($stmt_delete = $conn->prepare($sql_delete)) {
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        // Berhasil dihapus
        header("Location: supplier.php?status=sukses_hapus");
    } else {
        // Gagal menghapus karena alasan lain
        header("Location: supplier.php?status=gagal_hapus");
    }
    $stmt_delete->close();
} else {
    // Gagal menyiapkan query
    header("Location: supplier.php?status=gagal_hapus");
}

$conn->close();
exit();
?>