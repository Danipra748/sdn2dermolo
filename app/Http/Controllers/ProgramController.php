<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Support\SchoolData;
use Illuminate\Support\Facades\Schema;

class ProgramController extends Controller
{
    public function pramuka()
    {
        return $this->renderProgram($this->getProgramData('pramuka', [
            'title' => 'Ekstra Pramuka',
            'desc' => 'Pembinaan karakter, kemandirian, dan jiwa kepemimpinan siswa.',
            'hero_color' => 'from-blue-600 to-sky-600',
            'initial' => 'P',
            'highlights' => [
                'Latihan rutin baris-berbaris, tali-temali, dan penjelajahan.',
                'Pembentukan nilai disiplin, tanggung jawab, dan kerja sama.',
                'Kegiatan perkemahan untuk melatih kemandirian siswa.',
            ],
        ]));
    }

    public function seniUkir()
    {
        return $this->renderProgram($this->getProgramData('seni-ukir', [
            'title' => 'Seni Ukir',
            'desc' => 'Penguatan kreativitas siswa melalui seni dan budaya lokal.',
            'hero_color' => 'from-emerald-600 to-green-700',
            'initial' => 'U',
            'highlights' => [
                'Pengenalan motif ukir lokal dan unsur seni rupa dasar.',
                'Praktik teknik ukir sederhana sesuai usia siswa.',
                'Pembiasaan ketelitian, kesabaran, dan estetika karya.',
            ],
        ]));
    }

    public function drumband()
    {
        return $this->renderProgram($this->getProgramData('drumband', [
            'title' => 'Drumband',
            'desc' => 'Melatih kekompakan, ritme, dan kepercayaan diri siswa.',
            'hero_color' => 'from-amber-500 to-orange-600',
            'initial' => 'D',
            'highlights' => [
                'Latihan rutin ritme, tempo, dan formasi baris-berbaris.',
                'Pembagian peran alat musik untuk melatih koordinasi tim.',
                'Persiapan tampil pada kegiatan sekolah dan acara resmi.',
            ],
        ]));
    }

    private function getProgramData(string $slug, array $fallback): array
    {
        if (Schema::hasTable('programs')) {
            $program = Program::where('slug', $slug)->first();

            if ($program) {
                $photos = Schema::hasTable('program_photos')
                    ? $program->photos()->get()->map(function ($item) {
                        return [
                            'photo' => $item->photo,
                            'caption' => $item->caption,
                        ];
                    })->toArray()
                    : [];

                return array_merge($fallback, [
                    'title' => $program->title,
                    'desc' => $program->desc,
                    'foto' => $program->foto,
                    'logo' => $program->logo,
                    'emoji' => $program->emoji,
                    'hero_color' => $program->hero_color,
                    'highlights' => array_values(array_filter([
                        $program->highlight_1,
                        $program->highlight_2,
                        $program->highlight_3,
                    ])) ?: $fallback['highlights'],
                    'photos' => $photos,
                ]);
            }
        }

        $fromStatic = collect(SchoolData::program())->firstWhere('route', 'program.' . $slug);

        if ($fromStatic) {
            return array_merge($fallback, [
                'title' => $fromStatic['title'],
                'desc' => $fromStatic['desc'],
            ]);
        }

        return $fallback;
    }

    private function renderProgram(array $data)
    {
        $data['subtitle'] = $data['desc'] ?? ($data['subtitle'] ?? '');
        $data['initial'] = $data['initial'] ?? strtoupper(substr($data['title'] ?? 'P', 0, 1));
        $data['photos'] = $data['photos'] ?? [];

        return view('program.show', compact('data'));
    }
}
