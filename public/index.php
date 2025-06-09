<?php
// 1. Memuat header
require_once '../includes/header.php';

// --- LOGIKA UNTUK MENGAMBIL DATA RINGKASAN ---
$sql_produk = "SELECT COUNT(id) AS total_produk FROM products";
$result_produk = $conn->query($sql_produk);
$total_produk = $result_produk->fetch_assoc()['total_produk'];

$sql_supplier = "SELECT COUNT(id) AS total_supplier FROM suppliers";
$result_supplier = $conn->query($sql_supplier);
$total_supplier = $result_supplier->fetch_assoc()['total_supplier'];

$sql_stok = "SELECT SUM(stock) AS total_stok FROM products";
$result_stok = $conn->query($sql_stok);
$total_stok = $result_stok->fetch_assoc()['total_stok'] ?? 0;

$sql_penjualan_hari_ini = "SELECT COUNT(id) AS penjualan_hari_ini FROM sales WHERE DATE(sale_date) = CURDATE()";
$result_penjualan_hari_ini = $conn->query($sql_penjualan_hari_ini);
$penjualan_hari_ini = $result_penjualan_hari_ini->fetch_assoc()['penjualan_hari_ini'];
?>

<h1 class="mb-4">Dashboard</h1>
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-primary shadow h-100">
            <div class="card-body">
                <div class="card-title"><h5>Total Jenis Produk</h5></div>
                <p class="card-text display-4"><?php echo $total_produk; ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-success shadow h-100">
            <div class="card-body">
                <div class="card-title"><h5>Total Supplier</h5></div>
                <p class="card-text display-4"><?php echo $total_supplier; ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-warning shadow h-100">
            <div class="card-body">
                <div class="card-title"><h5>Total Stok Barang</h5></div>
                <p class="card-text display-4"><?php echo $total_stok; ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-danger shadow h-100">
            <div class="card-body">
                <div class="card-title"><h5>Transaksi Hari Ini</h5></div>
                <p class="card-text display-4"><?php echo $penjualan_hari_ini; ?></p>
            </div>
        </div>
    </div>
</div>


<?php
// 2. Menutup koneksi dan Memuat footer
$conn->close();
require_once '../includes/footer.php';
?>