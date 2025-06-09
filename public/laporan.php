<?php
require_once '../includes/header.php';
?>

<h1 class="mb-4">Halaman Laporan</h1>
<p class="mb-5">Halaman ini berisi berbagai jenis laporan yang dihasilkan dari query kompleks untuk memenuhi ketentuan proyek, termasuk berbagai jenis JOIN, fungsi, subquery, dan set operator.</p>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">1. Laporan Penjualan Rinci</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>INNER JOIN (2x):</strong> Menggabungkan 3 tabel (`sales`, `products`, `suppliers`) untuk mendapatkan data yang lengkap.<br>
            - <strong>Single Row Function:</strong> `DATE_FORMAT()` untuk mengubah format tanggal menjadi lebih mudah dibaca, dan `CONCAT()` untuk menggabungkan nama produk dan kategori.<br>
            - <strong>Calculated Field:</strong> Menghitung total harga (`quantity` * `price`).
        </p>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID Jual</th>
                        <th>Produk & Kategori (CONCAT)</th>
                        <th>Jml</th>
                        <th>Total Harga</th>
                        <th>Supplier</th>
                        <th>Tgl. Jual (DATE_FORMAT)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "SELECT 
                                s.id, 
                                CONCAT(p.name, ' (', p.category, ')') AS product_full,
                                s.quantity, 
                                (s.quantity * p.price) AS total_price, 
                                sup.name AS supplier_name,
                                DATE_FORMAT(s.sale_date, '%d %M %Y - %H:%i') AS formatted_date
                            FROM sales s
                            INNER JOIN products p ON s.product_id = p.id
                            INNER JOIN suppliers sup ON p.supplier_id = sup.id
                            ORDER BY s.sale_date DESC";
                    $result1 = $conn->query($sql1);
                    if ($result1->num_rows > 0) {
                        while ($row = $result1->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>" . htmlspecialchars($row['product_full']) . "</td>
                                    <td>{$row['quantity']}</td>
                                    <td>Rp " . number_format($row['total_price'], 0, ',', '.') . "</td>
                                    <td>" . htmlspecialchars($row['supplier_name']) . "</td>
                                    <td>{$row['formatted_date']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Belum ada data penjualan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">2. Laporan Produk yang Belum Pernah Terjual</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>LEFT JOIN:</strong> Digunakan untuk mencari produk yang tidak memiliki padanan di tabel `sales`.<br>
            - <strong>Emulasi MINUS/EXCEPT:</strong> Logika `WHERE s.id IS NULL` pada dasarnya melakukan operasi "semua produk DIKURANGI produk yang pernah terjual".
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Nama Produk</th><th>Kategori</th><th>Stok</th></tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT p.id, p.name, p.category, p.stock 
                             FROM products p 
                             LEFT JOIN sales s ON p.id = s.product_id 
                             WHERE s.id IS NULL";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['category']) . "</td>
                                    <td>{$row['stock']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>Semua produk sudah pernah terjual.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">3. Laporan Semua Supplier dan Produknya</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>RIGHT JOIN:</strong> Menampilkan **semua** data dari tabel kanan (`suppliers`), bahkan jika supplier tersebut belum memiliki produk. Nama produk akan tampil sebagai `NULL` (N/A) jika tidak ada.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr><th>Nama Supplier</th><th>Produk yang Disuplai</th></tr>
                </thead>
                <tbody>
                    <?php
                    $sql3 = "SELECT p.name AS product_name, s.name AS supplier_name
                             FROM products p
                             RIGHT JOIN suppliers s ON p.supplier_id = s.id
                             ORDER BY s.name, p.name";
                    $result3 = $conn->query($sql3);
                    if ($result3->num_rows > 0) {
                        while ($row = $result3->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['supplier_name']) . "</td>
                                    <td>" . htmlspecialchars($row['product_name'] ?? 'N/A - Belum ada produk') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>Tidak ada data supplier.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">4. Laporan Kontak Terpadu (Pengguna & Supplier)</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>UNION:</strong> Menggabungkan hasil dari dua `SELECT` yang berbeda (dari tabel `users` dan `suppliers`) menjadi satu set hasil tunggal.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr><th>Nama Kontak</th><th>Tipe</th></tr>
                </thead>
                <tbody>
                    <?php
                    // Pastikan tabel 'users' ada dan memiliki data dummy jika ingin mencoba
                    $sql4 = "(SELECT username AS nama, role AS tipe FROM users)
                             UNION
                             (SELECT name AS nama, 'Supplier' AS tipe FROM suppliers)
                             ORDER BY nama";
                    $result4 = $conn->query($sql4);
                    if ($result4->num_rows > 0) {
                        while ($row = $result4->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['nama']) . "</td>
                                    <td>" . htmlspecialchars($row['tipe']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>Tidak ada data pengguna atau supplier.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">5. Laporan Pasangan Produk dari Supplier yang Sama</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>SELF JOIN:</strong> Tabel `products` digabungkan dengan dirinya sendiri (`p1` dan `p2`) berdasarkan `supplier_id` yang sama untuk menemukan pasangan produk.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr><th>Produk A</th><th>Produk B</th><th>Supplier</th></tr>
                </thead>
                <tbody>
                    <?php
                    $sql5 = "SELECT p1.name AS product_a, p2.name AS product_b, s.name AS supplier_name
                             FROM products p1
                             JOIN products p2 ON p1.supplier_id = p2.supplier_id AND p1.id < p2.id
                             JOIN suppliers s ON p1.supplier_id = s.id
                             ORDER BY s.name, p1.name, p2.name";
                    $result5 = $conn->query($sql5);
                    if ($result5->num_rows > 0) {
                        while ($row = $result5->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['product_a']) . "</td>
                                    <td>" . htmlspecialchars($row['product_b']) . "</td>
                                    <td>" . htmlspecialchars($row['supplier_name']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Tidak ditemukan pasangan produk dari supplier yang sama.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow-sm mb-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">6. Laporan Potensi Kombinasi Promo (User x Produk)</h5>
    </div>
    <div class="card-body">
        <p class="card-text"><strong>Ketentuan yang Dipenuhi:</strong><br>
            - <strong>CROSS JOIN:</strong> Menghasilkan produk Cartesian, yaitu setiap baris dari tabel pertama (`users`) dipasangkan dengan setiap baris dari tabel kedua (`products`). Berguna untuk skenario yang membutuhkan semua kemungkinan kombinasi.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr><th>Username</th><th>Rekomendasi Produk</th></tr>
                </thead>
                <tbody>
                    <?php
                    $sql6 = "SELECT u.username, p.name AS product_name 
                             FROM users u CROSS JOIN products p
                             ORDER BY u.username, p.name";
                    $result6 = $conn->query($sql6);
                    if ($result6->num_rows > 0) {
                        while ($row = $result6->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>Tidak ada data user atau produk untuk dikombinasikan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
$conn->close();
require_once '../includes/footer.php';
?>