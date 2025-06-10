<?php
session_start();
require_once '../config/config.php';

// Inisialisasi variabel untuk mode edit
$edit_mode = false;
$kategori_to_edit = ['id_kategori' => '', 'nama_kategori' => ''];

// PROSES FORM (CREATE & UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aksi Tambah Kategori
    if (isset($_POST['tambah'])) {
        $nama_kategori = $_POST['nama_kategori'];
        if (!empty($nama_kategori)) {
            $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
            $stmt->execute([$nama_kategori]);
            $_SESSION['pesan'] = "Kategori baru berhasil ditambahkan.";
        }
    }
    // Aksi Update Kategori
    if (isset($_POST['update'])) {
        $id_kategori = $_POST['id_kategori'];
        $nama_kategori = $_POST['nama_kategori'];
        if (!empty($nama_kategori) && !empty($id_kategori)) {
            $stmt = $pdo->prepare("UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?");
            $stmt->execute([$nama_kategori, $id_kategori]);
            $_SESSION['pesan'] = "Kategori berhasil diperbarui.";
        }
    }
    header("Location: kategori.php");
    exit();
}

// PROSES HAPUS (DELETE)
if (isset($_GET['hapus'])) {
    $id_kategori = $_GET['hapus'];
    // Tambahan: Cek dulu apakah kategori masih dipakai oleh produk
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM produk WHERE id_kategori = ?");
    $stmt_check->execute([$id_kategori]);
    if ($stmt_check->fetchColumn() > 0) {
        $_SESSION['pesan_error'] = "Gagal menghapus! Kategori ini masih digunakan oleh produk lain.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        $stmt->execute([$id_kategori]);
        $_SESSION['pesan'] = "Kategori berhasil dihapus.";
    }
    header("Location: kategori.php");
    exit();
}

// PERSIAPAN TAMPILAN (READ)
// Cek apakah dalam mode edit
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_kategori = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $stmt->execute([$id_kategori]);
    $kategori_to_edit = $stmt->fetch();
}

// Ambil semua kategori untuk ditampilkan di tabel
$kategori_list = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll();

require_once '../src/templates/header.php';
?>

<main class="container">
    <h1>Manajemen Kategori</h1>

    <?php
    // Tampilkan pesan feedback jika ada
    if (isset($_SESSION['pesan'])) {
        echo '<div class="alert-sukses">' . $_SESSION['pesan'] . '</div>';
        unset($_SESSION['pesan']);
    }
    if (isset($_SESSION['pesan_error'])) {
        echo '<div class="alert-error">' . $_SESSION['pesan_error'] . '</div>';
        unset($_SESSION['pesan_error']);
    }
    ?>

    <div class="form-container">
        <?php if ($edit_mode): ?>
            <h3>Edit Kategori</h3>
            <form action="kategori.php" method="POST">
                <input type="hidden" name="id_kategori" value="<?= $kategori_to_edit['id_kategori']; ?>">
                <input type="text" name="nama_kategori" value="<?= htmlspecialchars($kategori_to_edit['nama_kategori']); ?>" required>
                <button type="submit" name="update" class="btn">Update</button>
                <a href="kategori.php" class="btn-batal">Batal</a>
            </form>
        <?php else: ?>
            <h3>Tambah Kategori Baru</h3>
            <form action="kategori.php" method="POST">
                <input type="text" name="nama_kategori" placeholder="Masukkan nama kategori baru" required>
                <button type="submit" name="tambah" class="btn">Tambah</button>
            </form>
        <?php endif; ?>
    </div>

    <hr class="separator">

    <h2>Daftar Kategori</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th>Nama Kategori</th>
                <th style="width: 20%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($kategori_list) > 0): ?>
                <?php foreach ($kategori_list as $index => $kategori): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($kategori['nama_kategori']); ?></td>
                        <td class="actions">
                            <a href="kategori.php?edit=<?= $kategori['id_kategori']; ?>" class="btn-edit">Edit</a>
                            <a href="kategori.php?hapus=<?= $kategori['id_kategori']; ?>" class="btn-hapus" onclick="return confirm('Anda yakin ingin menghapus kategori ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</main>

<?php
require_once '../src/templates/footer.php';
?>