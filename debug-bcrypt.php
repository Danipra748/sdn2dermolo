<?php
/**
 * DEBUG SCRIPT - Test Bcrypt Hash Verification
 * Upload ke server via File Manager, lalu akses via browser
 * HAPUS FILE INI SETELAH DIGUNAKAN!
 */

echo "<h1>🔍 Debug Bcrypt Hash Verification</h1>";
echo "<hr>";

// Test password
$test_password = 'admin12345';

// Generate hash baru
$generated_hash = password_hash($test_password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "<h2>1. Test Generate Hash</h2>";
echo "<p><strong>Password:</strong> $test_password</p>";
echo "<p><strong>Hash yang dihasilkan:</strong></p>";
echo "<textarea readonly style='width:100%; height:60px; font-family:monospace;'>$generated_hash</textarea>";
echo "<p><strong>Panjang hash:</strong> " . strlen($generated_hash) . " karakter</p>";

// Test verifikasi hash yang baru dibuat
$verify_new = password_verify($test_password, $generated_hash);
echo "<p><strong>Verifikasi hash baru:</strong> " . ($verify_new ? '✅ BERHASIL' : '❌ GAGAL') . "</p>";

echo "<hr>";
echo "<h2>2. Database Connection Info</h2>";

// Baca .env file jika ada
$env_file = dirname(__DIR__) . '/.env';
if (file_exists($env_file)) {
    $env_content = file_get_contents($env_file);
    echo "<p><strong>File .env ditemukan</strong></p>";
    echo "<pre style='background:#f0f0f0; padding:10px;'>" . htmlspecialchars($env_content) . "</pre>";
} else {
    echo "<p style='color:red;'><strong>❌ File .env TIDAK ditemukan!</strong></p>";
    echo "<p>Buat file .env dengan konfigurasi yang benar.</p>";
}

echo "<hr>";
echo "<h2>3. PHP Info</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>PDO Drivers:</strong> " . implode(', ', PDO::getAvailableDrivers()) . "</p>";
echo "<p><strong>Bcrypt Support:</strong> " . (defined('PASSWORD_BCRYPT') ? '✅ Ya' : '❌ Tidak') . "</p>";

echo "<hr>";
echo "<h2>4. SQL Query untuk Update Password</h2>";
echo "<p>Copy query ini dan jalankan di phpMyAdmin:</p>";
echo "<textarea readonly style='width:100%; height:80px; font-family:monospace;'>UPDATE users SET password = '$generated_hash' WHERE email = 'admin@sdn2dermolo.sch.id';</textarea>";

echo "<hr>";
echo "<h2>5. Test dengan Hash dari Database</h2>";
echo "<p>Masukkan hash dari database Anda untuk testing:</p>";
echo '<form method="post">';
echo '<textarea name="db_hash" style="width:100%; height:60px; font-family:monospace;" placeholder="Paste hash dari database..."></textarea>';
echo '<br><br>';
echo '<input type="submit" value="Test Hash" style="padding:10px 20px; background:#3b82f6; color:white; border:none; border-radius:5px; cursor:pointer;">';
echo '</form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_hash'])) {
    $db_hash = trim($_POST['db_hash']);
    
    echo "<h3>Hasil Test:</h3>";
    echo "<p><strong>Hash dari DB:</strong> $db_hash</p>";
    echo "<p><strong>Panjang:</strong> " . strlen($db_hash) . " karakter</p>";
    echo "<p><strong>Dimulai dengan \$2y\$:</strong> " . (str_starts_with($db_hash, '$2y$') ? '✅ Ya' : '❌ Tidak') . "</p>";
    
    // Coba verifikasi
    $verify_db = password_verify($test_password, $db_hash);
    echo "<p><strong>Verifikasi dengan password '$test_password':</strong> " . ($verify_db ? '✅ BERHASIL' : '❌ GAGAL') . "</p>";
    
    if (!$verify_db) {
        echo "<p style='color:red;'><strong>MASALAH:</strong> Hash di database tidak valid atau tidak cocok dengan password.</p>";
        echo "<p><strong>SOLUSI:</strong> Gunakan hash yang baru di-generate di atas dan update database.</p>";
    }
}

echo "<hr>";
echo "<p style='color:red; font-weight:bold;'>⚠️ PENTING: Hapus file ini setelah digunakan untuk keamanan!</p>";
echo "<p>Cara hapus: cPanel → File Manager → Cari file ini → Delete</p>";
?>
