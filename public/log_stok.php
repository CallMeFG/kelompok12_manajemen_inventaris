<?php
require_once '../config/config.php';
require_once '../src/templates/header.php';

// Mengambil data log stok, digabung dengan nama produk, diurutkan dari yang terbaru
try {
    $sql = "SELECT 
                ls.stok_lama, 
                ls.stok_baru, 
                ls.waktu_ubah, 
                p.nama_produk 
            FROM log_stok ls
            JOIN produk p ON ls.id_produk = p.id_produk
            ORDER BY ls.waktu_ubah DESC";

    $stmt = $pdo->query($sql);
    $logs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data log: " . $e->getMessage());
}
?>

<main class="container">
    <h1>Riwayat Perubahan Stok</h1>
   
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Ubah</th>
                <th>Nama Produk</th>
                <th>Stok Lama</th>
                <th>Stok Baru</th>
                <th>Perubahan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($logs) > 0): ?>
                <?php foreach ($logs as $index => $log): ?>
                    <?php
                    // Hitung perubahan dan tentukan class CSS-nya
                    $perubahan = $log['stok_baru'] - $log['stok_lama'];
                    $class_perubahan = $perubahan > 0 ? 'perubahan-positif' : 'perubahan-negatif';
                    $tanda = $perubahan > 0 ? '+' : '';
                    ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= date('d M Y, H:i:s', strtotime($log['waktu_ubah'])); ?></td>
                        <td><?= htmlspecialchars($log['nama_produk']); ?></td>
                        <td><?= $log['stok_lama']; ?></td>
                        <td><?= $log['stok_baru']; ?></td>
                        <td>
                            <span class="<?= $class_perubahan; ?>">
                                <?= $tanda . $perubahan; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada riwayat perubahan stok. Coba ubah stok salah satu produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php
require_once '../src/templates/footer.php';
?>