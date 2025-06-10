<?php
require_once '../includes/header.php';

$message = '';
$supplier = null;
$id = $_GET['id'] ?? null;

// 1. Redirect jika tidak ada ID di URL
if (!$id) {
    header("Location: supplier.php");
    exit();
}

// 2. Logika untuk memproses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_to_update = $_POST['id'];
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);

    // Validasi
    if (empty($name) || empty($contact)) {
        $message = '<div class="alert alert-danger">Nama dan Kontak wajib diisi.</div>';
        // Ambil kembali data lama untuk ditampilkan jika validasi gagal
        $supplier = ['id' => $id_to_update, 'name' => $name, 'contact' => $contact];
    } else {
        // Siapkan query UPDATE
        $sql_update = "UPDATE suppliers SET name = ?, contact = ? WHERE id = ?";
        
        if ($stmt_update = $conn->prepare($sql_update)) {
            $stmt_update->bind_param("ssi", $name, $contact, $id_to_update);
            
            if ($stmt_update->execute()) {
                header("Location: supplier.php?status=sukses_edit");
                exit();
            } else {
                $message = '<div class="alert alert-danger">Gagal mengupdate supplier: ' . $stmt_update->error . '</div>';
            }
            $stmt_update->close();
        }
    }
} else {
    // 3. Ambil data supplier untuk ditampilkan di form saat halaman pertama kali dibuka
    $sql_select = "SELECT * FROM suppliers WHERE id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        if ($result->num_rows == 1) {
            $supplier = $result->fetch_assoc();
        } else {
            $message = '<div class="alert alert-danger">Supplier tidak ditemukan.</div>';
        }
        $stmt_select->close();
    }
}
?>

<h1 class="mb-4">Edit Supplier</h1>

<?php echo $message; ?>

<?php if ($supplier): // Hanya tampilkan form jika data supplier ada ?>
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Formulir Edit Supplier: <?php echo htmlspecialchars($supplier['name']); ?></h5>
    </div>
    <div class="card-body">
        <form action="edit_supplier.php?id=<?php echo $id; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Supplier</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($supplier['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Kontak</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($supplier['contact']); ?>" required>
            </div>
            
            <a href="supplier.php" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?php
$conn->close();
require_once '../includes/footer.php';
?>