<?php
/**
 * Script untuk Generate Bcrypt Hash Laravel
 * Upload file ini ke server via cPanel File Manager
 * Lalu akses via browser: https://sdn2dermolo.sch.id/generate-hash.php
 */

// Password yang ingin di-hash
$password = 'admin12345';

// Generate hash dengan bcrypt cost 12
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "<h1>Generate Bcrypt Hash</h1>";
echo "<h2>Password: <code>$password</code></h2>";
echo "<h3>Hash (copy ini):</h3>";
echo "<textarea readonly style='width:100%; height:100px; font-family:monospace; font-size:14px;'>$hash</textarea>";
echo "<h3>SQL Query (copy & paste ke phpMyAdmin):</h3>";
echo "<textarea readonly style='width:100%; height:150px; font-family:monospace; font-size:14px;'>";
echo "UPDATE users SET password = '$hash' WHERE email = 'admin@sdn2dermolo.sch.id';";
echo "</textarea>";

echo "<h3>Verifikasi:</h3>";
echo "<p>Panjang hash: " . strlen($hash) . " karakter</p>";
echo "<p>Format valid: " . (str_starts_with($hash, '$2y$') ? '✅ YA' : '❌ TIDAK') . "</p>";

// Test verifikasi
if (password_verify($password, $hash)) {
    echo "<p style='color:green; font-weight:bold;'>✅ Hash VALID dan bisa diverifikasi</p>";
} else {
    echo "<p style='color:red; font-weight:bold;'>❌ Hash TIDAK VALID</p>";
}

echo "<hr>";
echo "<p><strong>PENTING:</strong> Hapus file ini setelah digunakan untuk keamanan!</p>";
?>
