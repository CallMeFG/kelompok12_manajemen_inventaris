<?php
require_once '../includes/header.php';

// Query untuk mengambil semua data supplier.
$sql = "SELECT
            s.id,
            UCASE(s.name) AS supplier_name,
            s.contact,
            (SELECT COUNT(*) FROM products p WHERE p.supplier_id = s.id) AS product_count
        FROM
            suppliers s
        ORDER BY
            id ASC";

$result = $conn->query($sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Supplier</h1>
    <a href="tambah_supplier.php" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Supplier
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Daftar Supplier</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Supplier (UCASE)</th>
                        <th>Kontak</th>
                        <th>Jumlah Produk (dari Subquery)</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["supplier_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["contact"]) . "</td>";
                            echo "<td>" . $row["product_count"] . "</td>";
                            echo "<td>
                                    <a href='edit_supplier.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>
                                        <i class='fa-solid fa-pen-to-square'></i> Edit
                                    </a>
                                    <a href='hapus_supplier.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Menghapus supplier juga dapat mempengaruhi data produk. Lanjutkan?');\">
                                        <i class='fa-solid fa-trash'></i> Hapus
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Belum ada data supplier.</td></tr>";
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