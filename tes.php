<?php
$password = 'admin'; // Ganti dengan password sebenarnya
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Password Ter-hash: " . $hashedPassword;
?>

semua passwordnya adalah admin