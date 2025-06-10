<?php
// Memanggil file koneksi, header, dan file-file yang diperlukan
require_once '../config/config.php';
require_once '../src/templates/header.php';

// Mengambil semua data produk dari VIEW yang sudah kita buat
// Kita juga memanggil FUNGSI fn_status_stok langsung di dalam query!
try {
    $stmt = $pdo->query("SELECT *, fn_status_stok(stok) as status_stok FROM v_produk_lengkap ORDER BY nama_produk ASC");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data produk: " . $e->getMessage());
}
?>

<main class="container">
    <div class="page-header">
        <h1>Daftar Produk</h1>
        <a href="produk_form.php" class="btn">Tambah Produk Baru</a>
    </div>
    <?php
    // Tampilkan pesan feedback jika ada
    session_start();
    if (isset($_SESSION['pesan'])) {
        echo '<div class="alert-sukses">' . $_SESSION['pesan'] . '</div>';
        unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($product['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($product['nama_kategori']); ?></td>
                        <td>Rp <?= number_format($product['harga'], 0, ',', '.'); ?></td>
                        <td><?= $product['stok']; ?></td>
                        <td>
                            <span class="status status-<?= strtolower(str_replace(' ', '-', $product['status_stok'])); ?>">
                                <?= htmlspecialchars($product['status_stok']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="produk_form.php?id=<?= $product['id_produk']; ?>" class="btn-edit">Edit</a>
                            <a href="produk_aksi.php?hapus=<?= $product['id_produk']; ?>" class="btn-hapus" onclick="return confirm('Anda yakin ingin menghapus produk ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada produk. Silakan tambahkan produk baru.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php
// Memanggil file footer
require_once '../src/templates/footer.php';
?>