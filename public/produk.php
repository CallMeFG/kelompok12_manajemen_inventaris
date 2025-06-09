<?php
require_once '../config/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 1000px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; }
        .btn-edit { background-color: #f0ad4e; color: white; }
        .btn-delete { background-color: #d9534f; color: white; }
        .btn-add { background-color: #5cb85c; color: white; margin-bottom: 15px; display: inline-block; }
    </style>
</head>
<body>
<div class="container">
    <h2>📦 Daftar Produk</h2>
    <a href="tambah_produk.php" class="btn btn-add">+ Tambah Produk</a>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "
                SELECT p.*, s.name AS supplier_name
                FROM products p
                LEFT JOIN suppliers s ON p.supplier_id = s.id
                ORDER BY p.name ASC
            ";
            $result = $conn->query($query);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                    <td><?= $row['stock'] ?> unit</td>
                    <td><?= htmlspecialchars($row['supplier_name']) ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                    </td>
                </tr>
            <?php
                endwhile;
            else:
                echo "<tr><td colspan='6'>Belum ada produk.</td></tr>";
            endif;
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
