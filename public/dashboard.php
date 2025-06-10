<?php
// Memanggil file koneksi dan header
require_once '../config/config.php';

// Menyiapkan query untuk mengambil data agregat
$total_produk = $pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$total_kategori = $pdo->query("SELECT COUNT(*) FROM kategori")->fetchColumn();
$total_stok = $pdo->query("SELECT SUM(stok) FROM produk")->fetchColumn();
$total_nilai_inventaris = $pdo->query("SELECT SUM(harga * stok) FROM produk")->fetchColumn();

require_once '../src/templates/header.php';
?>

<main class="container">

    <h1>Dashboard Inventaris</h1>
    <p>Selamat datang di sistem manajemen inventaris sederhana.</p>

    <div class="dashboard-cards">
        <div class="card">
            <h2>Total Produk</h2>
            <p><?= $total_produk ?? 0; ?></p>
        </div>
        <div class="card">
            <h2>Total Kategori</h2>
            <p><?= $total_kategori ?? 0; ?></p>
        </div>
        <div class="card">
            <h2>Jumlah Stok</h2>
            <p><?= $total_stok ?? 0; ?></p>
        </div>
        <div class="card">
            <h2>Nilai Inventaris</h2>
            <p>Rp <?= number_format($total_nilai_inventaris ?? 0, 2, ',', '.'); ?></p>
        </div>
    </div>

    <style>
        /* CSS khusus untuk halaman dashboard */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 2rem;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h2 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>

</main>
<?php
// Memanggil file footer
require_once '../src/templates/footer.php';
?>