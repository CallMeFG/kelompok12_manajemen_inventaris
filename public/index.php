<?php
// Memanggil file header
require_once '../src/templates/header.php';
?>

<div class="landing-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Sistem Manajemen Inventaris Modern</h1>
            <p>Solusi mudah untuk mengelola produk, melacak stok, dan menganalisis data inventaris toko Anda secara efisien.</p>
            <a href="dashboard.php" class="btn btn-primary">Masuk ke Aplikasi</a>
        </div>
    </div>
</div>

<main class="container">
    <div class="features-section">
        <h2>Fitur Utama Kami</h2>
        <div class="features-grid">
            <div class="feature-item">
                <img src="assets/images/icon-produk.svg" alt="Ikon Produk" class="feature-icon">
                <h3>Manajemen Produk</h3>
                <p>Tambah, edit, dan hapus produk dengan mudah. Kategorikan barang untuk pencarian yang lebih cepat.</p>
            </div>
            <div class="feature-item">
                <img src="assets/images/icon-stok.svg" alt="Ikon Stok" class="feature-icon">
                <h3>Pelacakan Stok Real-time</h3>
                <p>Pantau jumlah stok secara akurat. Dapatkan notifikasi untuk stok yang menipis.</p>
            </div>
            <div class="feature-item">
                <img src="assets/images/icon-laporan.svg" alt="Ikon Laporan" class="feature-icon">
                <h3>Laporan & Analisis</h3>
                <p>Lihat laporan ringkas tentang total aset, produk terlaris, dan performa bisnis Anda.</p>
            </div>
        </div>
    </div>
</main> <?php
        // Memanggil file footer
        // Perhatikan: tag <main> sekarang ditutup di atas ini, bukan di footer.php
        require_once '../src/templates/footer.php';
        ?>