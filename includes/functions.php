<?php
// Fungsi helper umum

// Contoh fungsi untuk format harga
function format_rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Contoh fungsi untuk notifikasi (bisa dikembangkan)
function alert($msg, $type = 'success') {
    return "<div style='padding:10px; background-color:" . 
        ($type === 'success' ? '#d4edda' : '#f8d7da') . 
        "; color:#155724; margin-bottom:10px; border-radius:5px;'>$msg</div>";
}
