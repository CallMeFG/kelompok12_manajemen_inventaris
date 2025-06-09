<?php
session_start();

// Hapus semua variabel session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login dengan pesan sukses
header("Location: login.php?status=logout_sukses");
exit();
?>