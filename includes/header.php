<?php
// Memulai session di setiap halaman
session_start();
// --- BLOK KODE BARU UNTUK KEAMANAN ---
// Cek apakah pengguna sudah login atau belum
// if (!isset($_SESSION['user_id'])) {
//     // Jika belum, paksa redirect ke halaman login
//     header('Location: ../auth/login.php');
//     exit();
// }
// // --- AKHIR BLOK KODE BARU ---
// Memasukkan file koneksi database
require_once __DIR__ . '/../config/db.php';

// TODO: Tambahkan pengecekan sesi login di sini nanti.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Manajemen Stok</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="produk.php">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="supplier.php">Supplier</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tambah_transaksi.php">Input Transaksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="laporan.php">Laporan</a>
        </li>
      </ul>
      <ul class="navbar-nav">
         <li class="nav-item">
            <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mt-4">
    