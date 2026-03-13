<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class FasilitasController extends Controller
{
    private const WARNA_TO_HERO = [
        'blue' => 'from-blue-500 to-cyan-600',
        'green' => 'from-emerald-600 to-teal-600',
        'yellow' => 'from-yellow-500 to-amber-600',
        'pink' => 'from-pink-500 to-rose-600',
        'purple' => 'from-purple-600 to-indigo-700',
        'orange' => 'from-orange-500 to-red-500',
    ];

    // =========================================================
    // ADMIN - index
    // =========================================================
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    // =========================================================
    // ADMIN - create
    // =========================================================
    public function create()
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => new Fasilitas(),
            'action' => route('admin.fasilitas.store'),
            'method' => 'POST',
            'title' => 'Tambah Fasilitas',
            'kontenValue' => '',
            'kontenTemplate' => $this->encodePrettyJson($this->getDefaultKontenTemplate('')),
            'kontenTemplates' => $this->getKontenTemplateMap(),
        ]);
    }

    // =========================================================
    // ADMIN - store
    // =========================================================
    public function store(Request $request)
    {
        $data = $this->validateFasilitas($request);
        if ($request->hasFile('icon_image')) {
            $data['icon_image'] = $request->file('icon_image')->store('fasilitas/icon', 'public');
        }
        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil ditambahkan.');
    }

    // =========================================================
    // ADMIN - edit
    // =========================================================
    public function edit(Fasilitas $fasilita)
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => $fasilita,
            'action' => route('admin.fasilitas.update', $fasilita),
            'method' => 'PUT',
            'title' => 'Edit Fasilitas',
            'kontenValue' => $this->encodePrettyJson($fasilita->konten ?? []),
            'kontenTemplate' => $this->encodePrettyJson($this->getDefaultKontenTemplate($fasilita->nama ?? '')),
            'kontenTemplates' => $this->getKontenTemplateMap(),
        ]);
    }

    // =========================================================
    // ADMIN - update
    // =========================================================
    public function update(Request $request, Fasilitas $fasilita)
    {
        $data = $this->validateFasilitas($request);

        if ($request->boolean('remove_icon_image') && $fasilita->icon_image) {
            Storage::disk('public')->delete($fasilita->icon_image);
            $data['icon_image'] = null;
        }

        if ($request->hasFile('icon_image')) {
            if ($fasilita->icon_image) {
                Storage::disk('public')->delete($fasilita->icon_image);
            }
            $data['icon_image'] = $request->file('icon_image')->store('fasilitas/icon', 'public');
        }

        $fasilita->update($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil diperbarui.');
    }

    // =========================================================
    // ADMIN - destroy
    // =========================================================
    public function destroy(Fasilitas $fasilita)
    {
        if ($fasilita->icon_image) {
            Storage::disk('public')->delete($fasilita->icon_image);
        }
        $fasilita->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil dihapus.');
    }

    private function validateFasilitas(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:10'],
            'icon_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'warna' => ['required', 'in:blue,green,yellow,pink,purple,orange'],
            'konten' => ['nullable', 'string'],
            'remove_icon_image' => ['nullable', 'boolean'],
        ]);

        $kontenRaw = trim((string) ($data['konten'] ?? ''));
        if ($kontenRaw === '') {
            $data['konten'] = null;
            return $data;
        }

        try {
            $decoded = json_decode($kontenRaw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw ValidationException::withMessages([
                'konten' => 'JSON tidak valid: ' . $exception->getMessage(),
            ]);
        }

        if (! is_array($decoded)) {
            throw ValidationException::withMessages([
                'konten' => 'JSON konten harus berbentuk object/array.',
            ]);
        }

        $data['konten'] = $decoded;

        return $data;
    }

    // =========================================================
    // PUBLIK - Ruang Kelas
    // =========================================================
    public function ruangKelas()
    {
        $data = $this->buildPublicData('Ruang Kelas');
        return view('fasilitas.ruang-kelas', compact('data'));
    }

    // =========================================================
    // PUBLIK - Perpustakaan
    // =========================================================
    public function perpustakaan()
    {
        $data = $this->buildPublicData('Perpustakaan');
        return view('fasilitas.perpustakaan', compact('data'));
    }

    // =========================================================
    // PUBLIK - Musholla
    // =========================================================
    public function musholla()
    {
        $data = $this->buildPublicData('Musholla');
        return view('fasilitas.musholla', compact('data'));
    }

    // =========================================================
    // PUBLIK - Lapangan Olahraga
    // =========================================================
    public function lapanganOlahraga()
    {
        $data = $this->buildPublicData('Lapangan Olahraga');
        return view('fasilitas.lapangan-olahraga', compact('data'));
    }

    private function buildPublicData(string $nama): array
    {
        $item = Fasilitas::where('nama', $nama)->first();
        $default = $this->getDefaultPublicData($nama);
        $konten = is_array($item?->konten) ? $item->konten : [];
        $data = array_replace_recursive($default, $konten);

        $warna = $item?->warna ?? 'blue';
        $defaultSubtitle = $default['subtitle'] ?? '';

        $data['title'] = $item?->nama ?? $nama;
        $data['subtitle'] = ($item && filled($item->deskripsi)) ? $item->deskripsi : $defaultSubtitle;
        $data['emoji'] = $item?->icon ?: ($default['emoji'] ?? '??');
        $data['icon_image'] = $item?->icon_image;
        $data['hero_color'] = self::WARNA_TO_HERO[$warna] ?? self::WARNA_TO_HERO['blue'];

        return $data;
    }

    private function encodePrettyJson(array $value): string
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
    }

    private function getDefaultKontenTemplate(string $nama): array
    {
        $default = $this->getDefaultPublicData($nama);

        unset($default['title'], $default['subtitle'], $default['emoji'], $default['hero_color']);

        return $default;
    }

    private function getKontenTemplateMap(): array
    {
        $names = ['Ruang Kelas', 'Perpustakaan', 'Musholla', 'Lapangan Olahraga'];
        $result = [];

        foreach ($names as $name) {
            $result[$name] = $this->encodePrettyJson($this->getDefaultKontenTemplate($name));
        }

        return $result;
    }

    private function getDefaultPublicData(string $nama): array
    {
        return match ($nama) {
            'Ruang Kelas' => [
                'subtitle' => 'Ruang kelas yang nyaman, rapi, dan mendukung proses belajar siswa.',
                'emoji' => '??',
                'border_color' => 'border-blue-500',
                'back_button_text' => 'Kembali ke Fasilitas',
                'description_title' => 'Tentang Ruang Kelas Kami',
                'description_paragraphs' => [
                    'SD N 2 Dermolo memiliki 18 ruang kelas yang dirancang untuk menciptakan suasana belajar yang optimal.',
                    'Setiap kelas dilengkapi fasilitas belajar modern agar proses belajar mengajar lebih efektif.',
                ],
                'stats_title' => 'Data Ruang Kelas',
                'stats' => [
                    ['value' => '18', 'label' => 'Ruang Kelas', 'icon' => '??', 'color' => 'blue'],
                    ['value' => '30', 'label' => 'Siswa per Kelas', 'icon' => '??', 'color' => 'green'],
                    ['value' => '63 m2', 'label' => 'Luas Ruang Kelas', 'icon' => '??', 'color' => 'purple'],
                    ['value' => '100%', 'label' => 'Terawat Baik', 'icon' => '?', 'color' => 'orange'],
                ],
                'kelas_title' => 'Pembagian Ruang Kelas',
                'kelas' => [
                    ['level' => 'Kelas 1', 'color' => 'red', 'rooms' => ['Kelas 1A - Ruang 01', 'Kelas 1B - Ruang 02', 'Kelas 1C - Ruang 03']],
                    ['level' => 'Kelas 2', 'color' => 'orange', 'rooms' => ['Kelas 2A - Ruang 04', 'Kelas 2B - Ruang 05', 'Kelas 2C - Ruang 06']],
                    ['level' => 'Kelas 3', 'color' => 'yellow', 'rooms' => ['Kelas 3A - Ruang 07', 'Kelas 3B - Ruang 08', 'Kelas 3C - Ruang 09']],
                    ['level' => 'Kelas 4', 'color' => 'green', 'rooms' => ['Kelas 4A - Ruang 10', 'Kelas 4B - Ruang 11', 'Kelas 4C - Ruang 12']],
                    ['level' => 'Kelas 5', 'color' => 'blue', 'rooms' => ['Kelas 5A - Ruang 13', 'Kelas 5B - Ruang 14', 'Kelas 5C - Ruang 15']],
                    ['level' => 'Kelas 6', 'color' => 'purple', 'rooms' => ['Kelas 6A - Ruang 16', 'Kelas 6B - Ruang 17', 'Kelas 6C - Ruang 18']],
                ],
                'fasilitas_title' => 'Fasilitas dan Kelengkapan Ruang Kelas',
                'fasilitas_items' => [
                    ['icon' => '??', 'title' => 'Air Conditioner (AC)', 'desc' => 'Setiap kelas dilengkapi AC untuk kenyamanan belajar.'],
                    ['icon' => '??', 'title' => 'LCD Proyektor', 'desc' => 'Media visual untuk presentasi dan pembelajaran interaktif.'],
                    ['icon' => '??', 'title' => 'Rak Buku Kelas', 'desc' => 'Koleksi buku referensi dan bacaan tambahan di kelas.'],
                    ['icon' => '???', 'title' => 'Papan Tulis Digital', 'desc' => 'Whiteboard dan smart-board untuk pembelajaran modern.'],
                ],
                'rules_title' => 'Tata Tertib Ruang Kelas',
                'tata_tertib_boleh' => [
                    'Masuk kelas dengan tertib dan mengucapkan salam.',
                    'Menjaga kebersihan kelas dan membuang sampah pada tempatnya.',
                    'Merapikan meja dan kursi setelah selesai belajar.',
                ],
                'tata_tertib_larang' => [
                    'Dilarang membuat kegaduhan di dalam kelas.',
                    'Dilarang mencoret meja, kursi, atau dinding.',
                    'Dilarang keluar masuk kelas tanpa izin guru.',
                ],
                'program_title' => 'Program Kelas Terbaik',
                'program_subtitle' => 'Kriteria penilaian kelas terbaik',
                'program_sections' => [
                    ['title' => 'Aspek Kebersihan (30%)', 'items' => ['Lantai bersih dan tidak ada sampah', 'Meja dan kursi rapi']],
                    ['title' => 'Aspek Kerapian (25%)', 'items' => ['Buku dan tas tersimpan rapi', 'Peralatan kelas lengkap']],
                    ['title' => 'Aspek Kedisiplinan (25%)', 'items' => ['Piket kelas teratur', 'Siswa hadir tepat waktu']],
                    ['title' => 'Aspek Prestasi (20%)', 'items' => ['Nilai akademik rata-rata baik', 'Keaktifan dalam kegiatan']],
                ],
                'cta_title' => 'Ruang Kelas yang Nyaman untuk Belajar',
                'cta_subtitle' => 'Lingkungan belajar yang kondusif adalah kunci kesuksesan akademik.',
                'cta_button_text' => 'Lihat Fasilitas Lainnya',
            ],
            'Perpustakaan' => [
                'subtitle' => 'Pusat literasi siswa dengan koleksi buku fisik dan digital.',
                'emoji' => '??',
                'back_button_text' => 'Kembali ke Fasilitas',
                'description_title' => 'Tentang Perpustakaan Kami',
                'description_paragraphs' => [
                    'Perpustakaan SD N 2 Dermolo menjadi pusat literasi bagi seluruh siswa.',
                    'Tersedia area baca nyaman, katalog digital, dan koleksi literatur beragam.',
                ],
                'stats_title' => 'Data dan Koleksi',
                'stats' => [
                    ['value' => '5.000+', 'label' => 'Koleksi Buku', 'icon' => '??', 'color' => 'emerald'],
                    ['value' => '10', 'label' => 'E-Book Point', 'icon' => '??', 'color' => 'blue'],
                    ['value' => '50+', 'label' => 'Pengunjung/Hari', 'icon' => '??', 'color' => 'amber'],
                    ['value' => 'A', 'label' => 'Akreditasi', 'icon' => '??', 'color' => 'rose'],
                ],
                'fasilitas_title' => 'Fasilitas Unggulan',
                'fasilitas_unggulan' => [
                    ['icon' => '??', 'title' => 'Area Baca Lesehan', 'desc' => 'Area baca santai yang nyaman untuk siswa.', 'bg' => 'emerald'],
                    ['icon' => '??', 'title' => 'Katalog Digital (OPAC)', 'desc' => 'Pencarian buku lebih cepat dan mandiri.', 'bg' => 'blue'],
                    ['icon' => '??', 'title' => 'Pojok Kreativitas', 'desc' => 'Ruang kegiatan literasi dan kreativitas.', 'bg' => 'amber'],
                    ['icon' => '?', 'title' => 'Sirkulasi Cepat', 'desc' => 'Peminjaman dan pengembalian buku lebih ringkas.', 'bg' => 'teal'],
                ],
                'rules_title' => 'Tata Tertib Perpustakaan',
                'tata_tertib_boleh' => [
                    'Menitipkan tas di loker yang disediakan.',
                    'Menjaga ketenangan di area baca.',
                ],
                'tata_tertib_larang' => [
                    'Dilarang membawa makanan dan minuman.',
                    'Dilarang merusak koleksi buku.',
                ],
                'cta_title' => 'Jelajahi Dunia Lewat Buku',
                'cta_subtitle' => 'Perpustakaan kami siap menjadi teman belajar terbaik.',
                'cta_button_text' => 'Lihat Fasilitas Lainnya',
            ],
            'Musholla' => [
                'subtitle' => 'Pusat kegiatan ibadah dan pembinaan karakter siswa.',
                'emoji' => '??',
                'back_button_text' => 'Kembali ke Fasilitas',
                'description_title' => 'Fasilitas Musholla',
                'description_paragraphs' => [
                    'Musholla sekolah digunakan untuk kegiatan ibadah harian siswa dan guru.',
                    'Area musholla dirawat rutin agar selalu bersih, nyaman, dan tertib.',
                ],
                'stats_title' => 'Kapasitas dan Inventaris',
                'stats' => [
                    ['value' => '1', 'label' => 'Unit Musholla', 'icon' => '??', 'color' => 'indigo'],
                    ['value' => '120+', 'label' => 'Kapasitas Jamaah', 'icon' => '??', 'color' => 'purple'],
                    ['value' => '2', 'label' => 'Tempat Wudhu', 'icon' => '??', 'color' => 'pink'],
                    ['value' => '100%', 'label' => 'Ruang Bersih', 'icon' => '?', 'color' => 'orange'],
                ],
                'program_title' => 'Kegiatan Ibadah',
                'program' => [
                    ['title' => 'Sholat Dhuha', 'desc' => 'Pembiasaan ibadah pagi siswa.', 'color' => 'indigo'],
                    ['title' => 'Sholat Dzuhur Berjamaah', 'desc' => 'Pembiasaan kebersamaan dalam ibadah.', 'color' => 'purple'],
                    ['title' => 'Pembinaan Akhlak', 'desc' => 'Pendampingan adab ibadah dan kebersihan.', 'color' => 'pink'],
                ],
                'rules_title' => 'Aturan Penggunaan Musholla',
                'tata_tertib_boleh' => [
                    'Berwudhu terlebih dahulu sebelum sholat.',
                    'Menjaga kebersihan area musholla dan tempat wudhu.',
                    'Merapikan perlengkapan ibadah setelah digunakan.',
                ],
                'tata_tertib_larang' => [
                    'Dilarang berbicara keras di area ibadah.',
                    'Dilarang membuang sampah sembarangan.',
                    'Dilarang merusak fasilitas musholla.',
                ],
                'cta_title' => 'Pembiasaan Ibadah Sejak Dini',
                'cta_subtitle' => 'Lingkungan sekolah mendukung karakter disiplin dan berakhlak.',
                'cta_button_text' => 'Lihat Fasilitas Lainnya',
            ],
            'Lapangan Olahraga' => [
                'subtitle' => 'Lapangan multifungsi untuk aktivitas olahraga dan pembinaan fisik siswa.',
                'emoji' => '??',
                'back_button_text' => 'Kembali ke Fasilitas',
                'description_title' => 'Fasilitas Lapangan Utama',
                'description_paragraphs' => [
                    'Lapangan sekolah dirancang sebagai area multifungsi yang aman untuk siswa.',
                    'Dilengkapi garis pembatas standar untuk berbagai cabang olahraga.',
                ],
                'stats_title' => 'Inventaris Olahraga',
                'stats' => [
                    ['value' => '2 Set', 'label' => 'Gawang Futsal', 'icon' => '??', 'color' => 'indigo'],
                    ['value' => '2 Unit', 'label' => 'Ring Basket', 'icon' => '??', 'color' => 'purple'],
                    ['value' => '1 Set', 'label' => 'Tiang Voli', 'icon' => '??', 'color' => 'pink'],
                    ['value' => '30+', 'label' => 'Alat Peraga PJOK', 'icon' => '??', 'color' => 'orange'],
                ],
                'program_title' => 'Program Olahraga',
                'program' => [
                    ['title' => 'Atletik Dasar', 'desc' => 'Lari, lompat, dan kebugaran jasmani dasar.', 'color' => 'indigo'],
                    ['title' => 'Permainan Bola', 'desc' => 'Futsal dan basket untuk kerja sama tim.', 'color' => 'purple'],
                    ['title' => 'Senam Irama', 'desc' => 'Kegiatan rutin untuk kebugaran siswa.', 'color' => 'pink'],
                ],
                'rules_title' => 'Tata Tertib Lapangan',
                'tata_tertib_boleh' => [
                    'Wajib menggunakan sepatu olahraga saat beraktivitas.',
                    'Mengembalikan alat olahraga ke gudang setelah digunakan.',
                ],
                'tata_tertib_larang' => [
                    'Dilarang membuang sampah di area lapangan.',
                    'Dilarang menggunakan fasilitas di luar jam sekolah tanpa izin.',
                ],
                'cta_title' => 'Sehat Jasmani, Kuat Rohani',
                'cta_subtitle' => 'Olahraga adalah investasi terbaik untuk kesehatan siswa.',
                'cta_button_text' => 'Lihat Fasilitas Lainnya',
            ],
            default => [
                'subtitle' => '',
                'emoji' => '??',
                'back_button_text' => 'Kembali ke Fasilitas',
                'description_title' => 'Tentang Fasilitas',
                'description_paragraphs' => [],
                'stats_title' => 'Data Fasilitas',
                'stats' => [],
                'rules_title' => 'Tata Tertib',
                'tata_tertib_boleh' => [],
                'tata_tertib_larang' => [],
                'cta_title' => 'Fasilitas Sekolah',
                'cta_subtitle' => '',
                'cta_button_text' => 'Lihat Fasilitas Lainnya',
            ],
        };
    }
}
