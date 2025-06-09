<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'];
    $category   = $_POST['category'];
    $price      = $_POST['price'];
    $stock      = $_POST['stock'];
    $supplier_id = $_POST['supplier_id'];

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, stock, supplier_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $name, $category, $price, $stock, $supplier_id);

    if ($stmt->execute()) {
        header("Location: produk.php?msg=success");
    } else {
        echo "Gagal menambahkan produk: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 15px; background: #5cb85c; color: white; border: none; border-radius: 5px; }
        a { display: inline-block; margin-top: 10px; color: #007bff; }
    </style>
</head>
<body>
<div class="container">
    <h2>➕ Tambah Produk Baru</h2>
    <form action="" method="POST">
        <label>Nama Produk:</label>
        <input type="text" name="name" required>

        <label>Kategori:</label>
        <input type="text" name="category" required>

        <label>Harga (Rp):</label>
        <input type="number" name="price" required>

        <label>Stok:</label>
        <input type="number" name="stock" required>

        <label>Supplier:</label>
        <select name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>
            <?php
            $suppliers = $conn->query("SELECT id, name FROM suppliers ORDER BY name ASC");
            while ($s = $suppliers->fetch_assoc()):
            ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Simpan</button>
    </form>
    <a href="produk.php">← Kembali ke Daftar Produk</a>
</div>
</body>
</html>
