<?php
require_once '../includes/header.php';

// Inisialisasi variabel untuk pesan
$message = '';

// Logika untuk memproses form saat disubmit (method POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan bersihkan dari spasi ekstra
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);

    // Validasi sederhana: pastikan field tidak kosong
    if (empty($name) || empty($contact)) {
        $message = '<div class="alert alert-danger">Nama dan Kontak Supplier wajib diisi.</div>';
    } else {
        // Siapkan query INSERT menggunakan prepared statement
        $sql = "INSERT INTO suppliers (name, contact) VALUES (?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter ke statement
            // "ss" berarti kedua parameter adalah string
            $stmt->bind_param("ss", $name, $contact);
            
            // Eksekusi statement
            if ($stmt->execute()) {
                // Jika berhasil, redirect ke halaman supplier
                header("Location: supplier.php?status=sukses_tambah");
                exit();
            } else {
                $message = '<div class="alert alert-danger">Gagal menyimpan supplier: ' . $stmt->error . '</div>';
            }
            // Tutup statement
            $stmt->close();
        } else {
            $message = '<div class="alert alert-danger">Gagal menyiapkan query: ' . $conn->error . '</div>';
        }
    }
}
?>

<h1 class="mb-4">Tambah Supplier Baru</h1>

<?php echo $message; // Tampilkan pesan sukses atau error jika ada ?>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Formulir Supplier</h5>
    </div>
    <div class="card-body">
        <form action="tambah_supplier.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Supplier</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Kontak (No. HP / Email)</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            
            <a href="supplier.php" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Supplier</button>
        </form>
    </div>
</div>

<?php
$conn->close();
require_once '../includes/footer.php';
?>