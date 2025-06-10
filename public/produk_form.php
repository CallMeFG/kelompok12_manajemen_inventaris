<?php
require_once '../config/config.php';

// Inisialisasi variabel
$id_produk = null;
$nama_produk = '';
$id_kategori = '';
$harga = '';
$stok = '';
$page_title = 'Tambah Produk Baru';
$action = 'tambah'; // Aksi default adalah 'tambah'

// Cek jika ada ID di URL (mode edit)
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $page_title = 'Edit Produk';
    $action = 'edit';

    try {
        $stmt = $pdo->prepare("SELECT * FROM produk WHERE id_produk = ?");
        $stmt->execute([$id_produk]);
        $product = $stmt->fetch();

        if ($product) {
            // Isi variabel dengan data dari database
            $nama_produk = $product['nama_produk'];
            $id_kategori = $product['id_kategori'];
            $harga = $product['harga'];
            $stok = $product['stok'];
        } else {
            die("Produk tidak ditemukan.");
        }
    } catch (PDOException $e) {
        die("Error mengambil data: " . $e->getMessage());
    }
}

// Mengambil semua data kategori untuk dropdown
try {
    $kategori_stmt = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori");
    $kategori_list = $kategori_stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data kategori: " . $e->getMessage());
}

require_once '../src/templates/header.php';
?>

<main class="container">
    <h1><?= $page_title; ?></h1>
    <a href="produk_tampil.php" class="btn-kembali">&larr; Kembali ke Daftar Produk</a>

    <form action="produk_aksi.php" method="POST" class="form-produk">
        <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
        <input type="hidden" name="action" value="<?= $action; ?>">

        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($nama_produk); ?>" required>
        </div>

        <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori_list as $kategori): ?>
                    <option value="<?= $kategori['id_kategori']; ?>" <?= ($kategori['id_kategori'] == $id_kategori) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($kategori['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($harga); ?>" required min="0">
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($stok); ?>" required min="0">
        </div>

        <button type="submit" class="btn"><?= ($action == 'edit') ? 'Simpan Perubahan' : 'Tambah Produk'; ?></button>
    </form>
</main>

<?php
require_once '../src/templates/footer.php';
?>