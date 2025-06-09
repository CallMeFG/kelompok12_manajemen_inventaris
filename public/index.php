<?php
require_once '../config/db.php'; // Koneksi ke database
require_once '../includes/functions.php'; // Fungsi bantu (opsional)

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Manajemen Stok</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .card h2 { margin: 0; }
    </style>
</head>
<body>
<div class="container">
    <h1>📊 Dashboard</h1>

    <?php
    // Total Produk
    $produk = $conn->query("SELECT COUNT(*) AS total FROM products");
    $produk_total = $produk->fetch_assoc()['total'];

    // Total Stok
    $stok = $conn->query("SELECT SUM(stock) AS total_stok FROM products");
    $total_stok = $stok->fetch_assoc()['total_stok'];

    // Total Transaksi
    $transaksi = $conn->query("SELECT COUNT(*) AS total_transaksi FROM sales");
    $total_transaksi = $transaksi->fetch_assoc()['total_transaksi'];

    // Total Pemasukan
    $pemasukan = $conn->query("SELECT SUM(p.price * s.quantity) AS total_pemasukan 
        FROM sales s 
        JOIN products p ON s.product_id = p.id");
    $total_pemasukan = $pemasukan->fetch_assoc()['total_pemasukan'];
    ?>

    <div class="card">
        <h2>Total Produk: <?= $produk_total ?> item</h2>
    </div>
    <div class="card">
        <h2>Total Stok: <?= $total_stok ?> unit</h2>
    </div>
    <div class="card">
        <h2>Total Transaksi: <?= $total_transaksi ?> penjualan</h2>
    </div>
    <div class="card">
        <h2>Total Pemasukan: Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h2>
    </div>
</div>
</body>
</html>
