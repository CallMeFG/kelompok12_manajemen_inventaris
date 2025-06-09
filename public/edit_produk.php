<?php
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data produk
$query = $conn->prepare("SELECT * FROM products WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows < 1) {
    die("Produk tidak ditemukan.");
}

$produk = $result->fetch_assoc();

// Proses update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'];
    $category   = $_POST['category'];
    $price      = $_POST['price'];
    $stock      = $_POST['stock'];
    $supplier_id = $_POST['supplier_id'];

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, stock=?, supplier_id=? WHERE id=?");
    $stmt->bind_param("ssiiii", $name, $category, $price, $stock, $supplier_id, $id);

    if ($stmt->execute()) {
        header("Location: produk.php?msg=updated");
    } else {
        echo "Gagal update produk: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 15px; background: #f0ad4e; color: white; border: none; border-radius: 5px; }
        a { display: inline-block; margin-top: 10px; color: #007bff; }
    </style>
</head>
<body>
<div class="container">
    <h2>✏️ Edit Produk</h2>
    <form action="" method="POST">
        <label>Nama Produk:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($produk['name']) ?>" required>

        <label>Kategori:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($produk['category']) ?>" required>

        <label>Harga (Rp):</label>
        <input type="number" name="price" value="<?= $produk['price'] ?>" required>

        <label>Stok:</label>
        <input type="number" name="stock" value="<?= $produk['stock'] ?>" required>

        <label>Supplier:</label>
        <select name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>
            <?php
            $suppliers = $conn->query("SELECT id, name FROM suppliers ORDER BY name ASC");
            while ($s = $suppliers->fetch_assoc()):
                $selected = ($produk['supplier_id'] == $s['id']) ? 'selected' : '';
            ?>
                <option value="<?= $s['id'] ?>" <?= $selected ?>><?= htmlspecialchars($s['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="produk.php">← Kembali ke Daftar Produk</a>
</div>
</body>
</html>
