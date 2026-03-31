<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'nama',
        'photo',
        'nip',
        'karpeg',
        'nuptk',
        'gender',
        'jabatan',
        'tempat_tgl_lahir',
        'ijazah',
        'mulai_bekerja_permulaan',
        'mulai_bekerja_di_sini',
        'masa_kerja_th',
        'masa_kerja_bl',
        'gol',
        'tmt',
        'gaji_pokok',
        'gr_kls_mp',
        'absen_s',
        'absen_i',
        'absen_a',
        'sk_akhir_tanggal',
        'sertifikasi_nmr_psrt',
        'sertifikasi_tahun',
        'sertifikasi_nrg',
    ];
}
