# Guru Form Grid Layout Update

## Changes Made to `resources/views/admin/guru/form.blade.php`

### New Grid Structure (Identitas Guru Section)

The form has been reorganized into a compact 2-column grid layout:

#### **Baris 1: Nama Lengkap (Full Width)**
- Nama Lengkap field spans the full width
- Required field for teacher name

#### **Baris 2: NIP dan Jabatan (Side by Side)**
- Left column: NIP (Nomor Induk Pegawai)
- Right column: Jabatan (Position/Role)

#### **Baris 3: Kategori dan Pendidikan (Side by Side)**
- Left column: Jenis Kelamin (Gender category - L/P)
- Right column: Pendidikan/Ijazah (Education level)

#### **Baris 4: Tempat/Tgl Lahir dan No Urut (Side by Side)**
- Left column: Tempat/Tgl Lahir (Birth place/date)
- Right column: No Urut (Display order number)

#### **Foto & Kepala Sekolah Section**
- Left column: Photo upload input
- Right column: 
  - Current photo preview (if exists)
  - Checkbox: "Hapus foto saat ini" (Delete current photo)
  - Checkbox: "Kepala Sekolah" (Principal status)

### Key Features

✅ **Compact Layout**: Reduced vertical scrolling with 2-column grid
✅ **Responsive**: Uses `grid-cols-1 md:grid-cols-2` for mobile responsiveness
✅ **Clean Design**: Maintains existing border-radius and blue button styling
✅ **Professional Look**: Organized with proper spacing and borders

### Note About Email Field

The original request mentioned an "Email" field, but the Guru model does not currently have an email field. If you need to add email functionality, you would need to:

1. Create a migration to add `email` column to the `gurus` table
2. Add `email` to the `$fillable` array in `app/Models/Guru.php`
3. Add the email field to the form

### Remaining Sections Unchanged

- **Data Kepegawaian** section (removed duplicate Ijazah field)
- **Informasi Tambahan** section (certification info)
- Submit/Cancel buttons

## How to Test

1. Visit `/admin/guru` in your browser
2. Click "Edit" on any teacher record
3. Verify the new compact 2-column layout
4. Check that all fields display correctly
5. Test the "Kepala Sekolah" checkbox functionality

## Date Created
April 9, 2026
