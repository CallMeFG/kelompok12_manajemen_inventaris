<?php
$host = 'localhost';           // Atau '127.0.0.1'
$user = 'root';                // Ubah jika pakai user lain
$pass = '';                    // Kosongkan jika tidak ada password
$dbname = 'projectbdl-1tib';   // Nama database dari screenshot kamu

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Jika ingin menampilkan pesan sukses (opsional)
// echo "Koneksi berhasil!";
?>
