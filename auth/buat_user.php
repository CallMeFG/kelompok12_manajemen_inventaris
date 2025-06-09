<?php
// Ganti 'admin123' dengan password yang Anda inginkan
$password_plain = 'admin123';

// Membuat hash dari password
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

echo "Password Plain: " . $password_plain . "<br>";
echo "Password Hashed: " . $password_hashed . "<br><br>";

echo "Salin hash di atas dan masukkan ke dalam database Anda.<br>";
echo "Contoh query SQL:<br>";
echo "<code>INSERT INTO users (username, password, role) VALUES ('admin', '$password_hashed', 'admin');</code>";
?>