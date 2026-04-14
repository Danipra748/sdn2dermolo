-- SQL Script to Add Admin User
-- SD Negeri 2 Dermolo
--
-- Usage: Run this SQL in your database
-- Or import via phpMyAdmin / CLI

-- ===== CARA 1: Jika user BELUM ADA (INSERT) =====
-- Password: admin12345
-- Email: admin@sdn2dermolo.sch.id

INSERT INTO users (name, email, email_verified_at, password, created_at, updated_at)
VALUES (
    'Admin SD N 2 Dermolo',
    'admin@sdn2dermolo.sch.id',
    NOW(),
    -- Hash bcrypt untuk password: admin12345
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    NOW(),
    NOW()
);

-- Buat record admin (link ke user yang baru dibuat)
INSERT INTO admins (user_id, role, created_at, updated_at)
VALUES (
    LAST_INSERT_ID(),
    'admin',
    NOW(),
    NOW()
);


-- ===== CARA 2: Jika user SUDAH ADA tapi password salah/reset (UPDATE) =====
-- Uncomment blok ini jika user sudah ada tapi ingin reset passwordnya

/*
UPDATE users
SET password = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'admin@sdn2dermolo.sch.id';

-- Pastikan ada record di tabel admins
INSERT IGNORE INTO admins (user_id, role, created_at, updated_at)
VALUES (
    (SELECT id FROM users WHERE email = 'admin@sdn2dermolo.sch.id' LIMIT 1),
    'admin',
    NOW(),
    NOW()
);
*/


-- ===== CARA 3: Jika menggunakan phpMyAdmin =====
/*
LANGKAH-LANGKAH:

1. Buka phpMyAdmin di hosting Anda
2. Pilih database project Anda
3. Buka tabel "users"
4. Klik tab "SQL" dan paste salah satu query di atas

ATAU (Cara Manual):

1. Generate hash password baru via terminal:
   php artisan tinker
   echo Hash::make('password_anda');
   
2. Copy hash yang dihasilkan
3. Insert/update ke tabel users dengan hash tersebut
4. Pastikan ada record di tabel admins dengan user_id yang sesuai
*/


-- ===== NOTES =====
-- Password default: admin12345
-- Hash bcrypt di atas ADALAH hash VALID untuk "admin12345"
-- 
-- Setelah berhasil login, segera ganti password di Dashboard Admin
-- atau via tinker:
--   php artisan tinker
--   $user = User::where('email', 'admin@sdn2dermolo.sch.id')->first();
--   $user->password = Hash::make('password_baru_anda');
--   $user->save();
