<?php
require_once '../includes/header.php';

$message = '';
$product = null;
$id = $_GET['id'] ?? null;

// 1. Cek apakah ID valid dan ambil data produk untuk ditampilkan di form
if ($id) {
    $sql_select = "SELECT * FROM products WHERE id = ?";
    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        if ($result->num_rows == 1) {
            $product = $result->fetch_assoc();
        } else {
            $message = '<div class="alert alert-danger">Produk tidak ditemukan.</div>';
        }
        $stmt_select->close();
    }
} else {
    // Redirect jika tidak ada ID
    header("Location: produk.php");
    exit();
}

// 2. Logika untuk memproses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_to_update = $_POST['id'];
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $supplier_id = trim($_POST['supplier_id']);

    // Validasi
    if (empty($name) || empty($category) || empty($price) || empty($stock) || empty($supplier_id)) {
        $message = '<div class="alert alert-danger">Semua field wajib diisi.</div>';
    } else {
        // Siapkan query UPDATE menggunakan prepared statement
        $sql_update = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, supplier_id = ? WHERE id = ?";
        
        if ($stmt_update = $conn->prepare($sql_update)) {
            $stmt_update->bind_param("ssdiis", $name, $category, $price, $stock, $supplier_id, $id_to_update);
            
            if ($stmt_update->execute()) {
                header("Location: produk.php?status=sukses_edit");
                exit();
            } else {
                $message = '<div class="alert alert-danger">Gagal mengupdate produk: ' . $stmt_update->error . '</div>';
            }
            $stmt_update->close();
        }
    }
    // Refresh data produk setelah post untuk menampilkan nilai terbaru di form jika ada error
    $product = $_POST;
}

// Query untuk mengambil data supplier untuk dropdown
$sql_suppliers = "SELECT id, name FROM suppliers ORDER BY name ASC";
$result_suppliers = $conn->query($sql_suppliers);

?>

<h1 class="mb-4">Edit Produk</h1>

<?php echo $message; ?>

<?php if ($product): // Hanya tampilkan form jika produk ditemukan ?>
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Formulir Edit Produk: <?php echo htmlspecialchars($product['name']); ?></h5>
    </div>
    <div class="card-body">
        <form action="edit_produk.php?id=<?php echo $id; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select class="form-select" id="supplier_id" name="supplier_id" required>
                    <option value="">-- Pilih Supplier --</option>
                    <?php
                    if ($result_suppliers->num_rows > 0) {
                        while ($supplier = $result_suppliers->fetch_assoc()) {
                            // Cek untuk menandai supplier yang sedang dipilih
                            $selected = ($supplier['id'] == $product['supplier_id']) ? 'selected' : '';
                            echo '<option value="' . $supplier['id'] . '" ' . $selected . '>' . htmlspecialchars($supplier['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <a href="produk.php" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?php
$conn->close();
require_once '../includes/footer.php';
?>  