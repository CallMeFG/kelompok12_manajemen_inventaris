<?php
// Memuat header, yang juga memuat koneksi database
require_once '../includes/header.php';

// Query untuk mengambil semua data produk beserta nama suppliernya.
// Kita menggunakan LEFT JOIN untuk menggabungkan tabel 'products' dan 'suppliers'
// berdasarkan kolom 'supplier_id'.
$sql = "SELECT p.id, p.name, p.category, p.price, p.stock, s.name AS supplier_name
        FROM products p
        LEFT JOIN suppliers s ON p.supplier_id = s.id
        ORDER BY p.id DESC"; // Mengurutkan agar produk terbaru muncul di atas

$result = $conn->query($sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Produk</h1>
    <a href="tambah_produk.php" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Daftar Produk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Supplier</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Cek jika query mengembalikan baris data
                    if ($result->num_rows > 0) {
                        // Looping untuk menampilkan setiap baris data
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
                            echo "<td>Rp " . number_format($row["price"], 0, ',', '.') . "</td>";
                            echo "<td>" . $row["stock"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["supplier_name"] ?? 'Tidak Ada') . "</td>";
                            echo "<td>
                                    <a href='edit_produk.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>
                                        <i class='fa-solid fa-pen-to-square'></i> Edit
                                    </a>
                                    <a href='hapus_produk.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Apakah Anda yakin ingin menghapus produk ini?');\">
                                        <i class='fa-solid fa-trash'></i> Hapus
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        // Jika tidak ada data produk, tampilkan pesan ini
                        echo "<tr><td colspan='7' class='text-center'>Belum ada data produk. Silakan tambahkan produk baru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Menutup koneksi database dan memuat footer
$conn->close();
require_once '../includes/footer.php';
?>