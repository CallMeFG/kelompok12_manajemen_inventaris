<?php
require_once '../includes/header.php';

$message = '';

// Logika untuk memproses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Validasi dasar
    if (empty($product_id) || empty($quantity) || $quantity <= 0) {
        $message = '<div class="alert alert-danger">Silakan pilih produk dan masukkan jumlah yang valid.</div>';
    } else {
        // Memulai mode transaction
        $conn->begin_transaction();

        try {
            // 1. Ambil stok saat ini dan kunci baris untuk update (FOR UPDATE)
            $sql_check_stock = "SELECT name, stock FROM products WHERE id = ? FOR UPDATE";
            $stmt_check = $conn->prepare($sql_check_stock);
            $stmt_check->bind_param("i", $product_id);
            $stmt_check->execute();
            $result_stock = $stmt_check->get_result();
            $product = $result_stock->fetch_assoc();
            
            if (!$product || $product['stock'] < $quantity) {
                // Jika produk tidak ada atau stok tidak mencukupi, batalkan transaksi
                throw new Exception("Stok produk '" . htmlspecialchars($product['name']) . "' tidak mencukupi (Sisa: {$product['stock']}).");
            }
            $stmt_check->close();

            // 2. Jika stok cukup, catat penjualan ke tabel 'sales'
            $sql_insert_sale = "INSERT INTO sales (product_id, quantity) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert_sale);
            $stmt_insert->bind_param("ii", $product_id, $quantity);
            $stmt_insert->execute();
            $stmt_insert->close();

            // 3. Kurangi stok di tabel 'products'
            $sql_update_stock = "UPDATE products SET stock = stock - ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update_stock);
            $stmt_update->bind_param("ii", $quantity, $product_id);
            $stmt_update->execute();
            $stmt_update->close();

            // 4. Jika semua query berhasil, simpan perubahan secara permanen
            $conn->commit();
            $message = '<div class="alert alert-success">Transaksi berhasil dicatat.</div>';

        } catch (Exception $e) {
            // Jika terjadi error di salah satu langkah, batalkan semua perubahan
            $conn->rollback();
            $message = '<div class="alert alert-danger">Transaksi Gagal: ' . $e->getMessage() . '</div>';
        }
    }
}

// Query untuk mengambil data produk untuk dropdown
$sql_products = "SELECT id, name, stock FROM products WHERE stock > 0 ORDER BY name ASC";
$result_products = $conn->query($sql_products);
?>

<h1 class="mb-4">Input Transaksi Penjualan</h1>

<?php echo $message; // Tampilkan pesan sukses atau error ?>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Formulir Transaksi Baru</h5>
    </div>
    <div class="card-body">
        <form action="tambah_transaksi.php" method="POST">
            <div class="mb-3">
                <label for="product_id" class="form-label">Produk</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php
                    if ($result_products->num_rows > 0) {
                        while ($product_option = $result_products->fetch_assoc()) {
                            echo '<option value="' . $product_option['id'] . '">' . htmlspecialchars($product_option['name']) . ' (Stok: ' . $product_option['stock'] . ')</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Jumlah Terjual</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>
</div>

<?php
// Tidak perlu $conn->close() di sini karena mungkin sudah ditutup di header/footer
require_once '../includes/footer.php';
?>