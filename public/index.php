<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Sedikit style kustom untuk tampilan yang lebih baik */
        .hero {
            background: #f8f9fa;
            padding: 6rem 0;
        }
        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
        .section {
            padding: 4rem 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Manajemen Stok</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                </ul>
                <a href="auth/login.php" class="btn btn-primary ms-lg-3">Login</a>
            </div>
        </div>
    </nav>

    <header class="hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Solusi Manajemen Stok yang Efisien</h1>
            <p class="lead text-muted my-4">Kelola produk, lacak transaksi, dan pantau supplier Anda dalam satu platform yang mudah digunakan.</p>
            <a href="../public/dashboard.php" class="btn btn-primary btn-lg">Mulai Kelola Sekarang</a>
        </div>
    </header>

    <section id="fitur" class="section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <h2 class="mb-5">Fitur Unggulan Kami</h2>
                </div>
            </div>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <h3>Manajemen Produk</h3>
                    <p class="text-muted">Tambah, lihat, ubah, dan hapus data produk dengan mudah. Lacak stok secara real-time.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3>Laporan Analitis</h3>
                    <p class="text-muted">Dapatkan wawasan dari laporan penjualan terperinci, produk terlaris, dan data historis lainnya.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3>Kelola Supplier & Transaksi</h3>
                    <p class="text-muted">Catat semua transaksi penjualan dan kelola data supplier Anda untuk operasional yang lancar.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="tentang" class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4">Tentang Proyek Ini</h2>
                    <p class="lead text-muted">Aplikasi ini adalah sistem manajemen stok berbasis web yang dibangun menggunakan PHP native, MySQL, dan Bootstrap. Proyek ini dirancang untuk menyediakan fungsionalitas inti dalam pengelolaan inventaris secara efisien dan aman.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white">
        <div class="container text-center">
            <p class="mb-0">Copyright &copy; <?php echo date("Y"); ?> Proyek Manajemen Stok</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>