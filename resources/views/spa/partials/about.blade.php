 {{-- About/Tentang Kami SPA Partial - Redesigned --}}

{{-- ===== HERO SECTION ===== --}}
<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            PROFIL SEKOLAH
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Mengenal Lebih Dekat SD Negeri 2 Dermolo
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Sekolah berkomitmen memberikan pendidikan berkualitas tinggi dengan mengutamakan kecerdasan akademik dan pembentukan karakter generasi muda Indonesia.
        </p>
    </div>
</section>

{{-- ===== STATISTICS SECTION ===== --}}
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">STATISTIK SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3">SD Negeri 2 Dermolo dalam Angka</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- Total Students --}}
            <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center border border-blue-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-black text-blue-600 mb-2">{{ $profile->total_students ?? '200' }}+</div>
                <div class="text-sm text-slate-600 font-medium">Total Siswa</div>
            </div>

            {{-- Total Classes --}}
            <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center border border-green-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="text-3xl font-black text-green-600 mb-2">{{ $profile->total_classes ?? '12' }}</div>
                <div class="text-sm text-slate-600 font-medium">Ruang Kelas</div>
            </div>

            {{-- Total Teachers --}}
            <div class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center border border-purple-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-3xl font-black text-purple-600 mb-2">{{ $profile->total_teachers ?? '15' }}</div>
                <div class="text-sm text-slate-600 font-medium">Tenaga Pendidik</div>
            </div>

            {{-- Land Area --}}
            <div class="group bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl p-6 text-center border border-amber-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
                <div class="text-3xl font-black text-amber-600 mb-2">{{ $profile->land_area ?? '1.400' }}</div>
                <div class="text-sm text-slate-600 font-medium">Luas Tanah (m²)</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== KEPALA SEKOLAH SAMBUTAN SECTION ===== --}}
@if($fotoKepsek || $sambutanFoto || $sambutanText || $kepsek)
<section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">SAMBUTAN KEPALA SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Pesan dari Pimpinan</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">Sambutan dan visi dari Kepala SD Negeri 2 Dermolo untuk masyarakat</p>
        </div>

        <div class="grid md:grid-cols-[1fr_1.5fr] gap-12 items-start">
            {{-- Left: Foto Kepala Sekolah --}}
            <div class="flex flex-col items-center">
                @if ($fotoKepsek)
                    <div class="w-full max-w-sm overflow-hidden rounded-2xl border-4 border-white shadow-2xl mb-6">
                        <img src="{{ asset('storage/' . $fotoKepsek) }}"
                             alt="Foto Kepala Sekolah"
                             class="w-full h-full object-cover aspect-[4/5]">
                    </div>
                @elseif ($sambutanFoto)
                    <div class="w-full max-w-sm overflow-hidden rounded-2xl shadow-xl mb-6">
                        <img src="{{ asset('storage/' . $sambutanFoto) }}"
                             alt="Foto Kepala Sekolah"
                             class="w-full h-full object-cover aspect-[4/5]">
                    </div>
                @else
                    <div class="w-full max-w-sm aspect-[4/5] rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 shadow-xl flex items-center justify-center mb-6">
                        <svg class="w-32 h-32 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif

                @if($kepsek)
                <div class="text-center">
                    <h3 class="text-xl font-bold text-slate-900">{{ $kepsek->nama }}</h3>
                    <p class="text-sm text-slate-600">{{ $kepsek->jabatan }}</p>
                </div>
                @endif
            </div>

            {{-- Right: Sambutan Text --}}
            @if($sambutanText)
            <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-8 md:p-10 border border-slate-200">
                <div class="prose prose-lg max-w-none">
                    <div class="text-slate-700 leading-relaxed whitespace-pre-line text-base">
                        {{ $sambutanText }}
                    </div>
                </div>

                @if($kepsek)
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <p class="font-bold text-slate-900 text-lg">{{ $kepsek->nama }}</p>
                    <p class="text-sm text-slate-600">{{ $kepsek->jabatan }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="flex items-center justify-center h-full">
                <div class="text-center text-slate-400">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <p class="text-lg font-medium">Sambutan belum tersedia</p>
                    <p class="text-sm mt-2">Silakan hubungi admin untuk menambahkan sambutan</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ===== SCHOOL PROFILE & INFORMATION ===== --}}
<section class="py-16 px-4 bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">INFORMASI SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3">Profil & Identitas Sekolah</h2>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Left Column - Main Profile Card (40%) --}}
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl p-8 text-center text-white shadow-2xl relative overflow-hidden h-full">
                    {{-- Background Pattern --}}
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 30px 30px;"></div>

                    <div class="relative z-10">
                        {{-- Logo --}}
                        <div class="w-36 h-36 mx-auto mb-6 rounded-2xl bg-white shadow-2xl overflow-hidden border-4 border-white/30">
                            @if($profile->logo)
                                <img src="{{ asset('storage/' . $profile->logo) }}" alt="{{ $profile->school_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-6xl font-black text-blue-600">SD</div>
                                </div>
                            @endif
                        </div>

                        {{-- School Name --}}
                        <h3 class="text-3xl font-bold mb-3">{{ $profile->school_name }}</h3>
                        <p class="text-blue-100 text-sm mb-6 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ Str::limit($profile->address ?? 'Desa Dermolo', 60) }}
                        </p>

                        {{-- Accreditation Badge --}}
                        <div class="inline-block px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm text-sm font-semibold mb-6 border border-white/30">
                            <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Terakreditasi {{ $profile->accreditation ?? 'B' }}
                        </div>

                        {{-- Key Stats --}}
                        <div class="grid grid-cols-2 gap-4 pt-6 border-t border-white/20">
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-3xl font-bold mb-1">{{ $profile->established_year ?? '1977' }}</div>
                                <div class="text-xs text-blue-100">Tahun Berdiri</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-3xl font-bold mb-1">{{ $profile->total_classes ?? '12' }}</div>
                                <div class="text-xs text-blue-100">Ruang Kelas</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm col-span-2">
                                <div class="text-3xl font-bold mb-1">{{ $profile->land_area ?? '1.400' }} m²</div>
                                <div class="text-xs text-blue-100">Luas Tanah</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column - Information Cards (60%) --}}
            <div class="lg:col-span-3 space-y-6">
                {{-- Basic Information Card --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900">Informasi Dasar</h4>
                    </div>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <div class="text-xs text-slate-500 mb-1">NPSN</div>
                            <div class="font-bold text-slate-900 text-lg">{{ $profile->npsn ?? '20318087' }}</div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <div class="text-xs text-slate-500 mb-1">Status</div>
                            <div class="font-bold text-slate-900 text-lg">{{ $profile->school_status ?? 'Negeri' }}</div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <div class="text-xs text-slate-500 mb-1">Akreditasi</div>
                            <div class="font-bold text-slate-900 text-lg">{{ $profile->accreditation ?? 'B' }}</div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <div class="text-xs text-slate-500 mb-1">Kecamatan</div>
                            <div class="font-bold text-slate-900 text-lg">{{ $profile->district ?? 'Kembang' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Contact & Communication Card --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900">Kontak & Komunikasi</h4>
                    </div>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
                            <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Telepon</div>
                                <div class="font-bold text-slate-900">{{ $kontak['phone'] ?? '0896-6898-2633' }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200">
                            <div class="w-10 h-10 rounded-lg bg-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Email</div>
                                <div class="font-bold text-slate-900 text-sm">{{ $kontak['email'] ?? 'sdndermolo728@gmail.com' }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 sm:col-span-2">
                            <div class="w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs text-slate-500 mb-1">Jam Operasional</div>
                                <div class="font-bold text-slate-900">Senin - Jumat: 07.00 - 14.00 WIB</div>
                                <div class="text-sm text-slate-600">Sabtu: 07.00 - 13.00 WIB</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="flex flex-wrap gap-3">
                    <a href="https://wa.me/6289668982633" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold hover:from-green-600 hover:to-green-700 transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        Hubungi via WhatsApp
                    </a>
                    <a href="https://maps.google.com/?q=SD+Negeri+2+Dermolo,+Kembang,+Jepara" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold hover:from-blue-600 hover:to-blue-700 transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $missions = is_array($profile->missions)
        ? collect($profile->missions)->map(fn ($item) => trim((string) $item))->filter()->values()
        : collect(preg_split('/\r\n|\r|\n/', (string) ($profile->missions ?? '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values();
@endphp

{{-- ===== VISI & MISI ===== --}}
@if($profile->vision || $missions->isNotEmpty())
<section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">VISI & MISI</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Arah & Tujuan Kami</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">Komitmen kami untuk memberikan pendidikan terbaik bagi generasi penerus bangsa</p>
        </div>

        {{-- Visi Card - Large Quote Style --}}
        @if($profile->vision)
        <div class="max-w-4xl mx-auto mb-16">
            <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 rounded-3xl p-8 md:p-12 text-white shadow-2xl overflow-hidden">
                {{-- Background Decoration --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-sky-400/10 rounded-full -ml-24 -mb-24 blur-3xl"></div>
                
                <div class="relative z-10">
                    {{-- Icon --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    
                    {{-- Label --}}
                    <div class="text-center mb-6">
                        <span class="inline-block px-6 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-bold tracking-wider border border-white/30">VISI SEKOLAH</span>
                    </div>
                    
                    {{-- Quote --}}
                    <blockquote class="text-center">
                        <p class="text-xl md:text-2xl lg:text-3xl font-medium leading-relaxed italic">
                            "{{ $profile->vision }}"
                        </p>
                    </blockquote>
                    
                    {{-- Decorative Quote Mark --}}
                    <div class="text-center mt-6">
                        <svg class="w-12 h-12 mx-auto text-white/30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Misi Cards - Grid Layout --}}
        @if($missions->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold text-slate-900 mb-8 text-center">MISI KAMI</h3>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($missions as $index => $mission)
                <div class="group bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-lg hover:shadow-2xl hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
                    {{-- Number Badge --}}
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-xl font-bold mb-4 shadow-lg group-hover:scale-110 transition-transform">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    {{-- Mission Text --}}
                    <p class="text-slate-700 leading-relaxed">{{ $mission }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endif

{{-- ===== SEJARAH SEKOLAH ===== --}}
@if($profile->history_content)
<section id="sejarah" class="py-20 px-4 bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <span class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold">SEJARAH SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Perjalanan {{ $profile->school_name }}</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">Mengenal lebih dekat perjalanan dan pencapaian sekolah kami dari tahun ke tahun</p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- Main Content (60%) --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-200">
                    <div class="prose prose-lg max-w-none">
                        <div class="text-slate-700 leading-relaxed whitespace-pre-line text-base">{{ $profile->history_content }}</div>
                    </div>
                </div>
            </div>

            {{-- Sidebar - Quick Facts (40%) --}}
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-8 border border-slate-200 shadow-lg sticky top-24">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        Fakta Singkat
                    </h3>
                    
                    <div class="space-y-4">
                        @if($profile->established_year)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Tahun Berdiri</div>
                                <div class="font-bold text-slate-900 text-lg">{{ $profile->established_year }}</div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Status</div>
                                <div class="font-bold text-slate-900">{{ $profile->school_status ?? 'Negeri' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Akreditasi</div>
                                <div class="font-bold text-slate-900">{{ $profile->accreditation ?? 'B' }}</div>
                            </div>
                        </div>

                        @if($profile->total_classes)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Jumlah Kelas</div>
                                <div class="font-bold text-slate-900">{{ $profile->total_classes }} Rombel</div>
                            </div>
                        </div>
                        @endif

                        @if($profile->total_students)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Total Siswa</div>
                                <div class="font-bold text-slate-900">{{ number_format($profile->total_students) }}+ siswa</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($profile->land_area)
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-slate-200">
                            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-home text-cyan-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500 mb-1">Luas Tanah</div>
                                <div class="font-bold text-slate-900">± {{ $profile->land_area }} m²</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== MAPS & LOCATION ===== --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-green-100 text-green-700 text-sm font-semibold">LOKASI KAMI</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-4">Temukan Kami di Peta</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">SD Negeri 2 Dermolo berlokasi strategis di Kecamatan Kembang, Kabupaten Jepara</p>
        </div>

        <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-3xl p-4 border border-slate-200 shadow-xl">
            <div class="rounded-2xl overflow-hidden">
                @include('partials.school-map-embed', [
                    'containerClass' => 'kontak-map relative overflow-hidden rounded-2xl border-0 bg-white shadow-lg',
                    'height' => '400px',
                ])
            </div>
            
            <div class="p-6 mt-4 bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-900 text-lg mb-2">Alamat Lengkap</h4>
                        <p class="text-slate-600">{{ $alamatLines->implode(', ') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CALL TO ACTION - BACK TO HOME ===== --}}
<section class="py-20 px-4 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
    {{-- Background Decoration --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl -ml-36 -mt-36"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl -mr-48 -mb-48"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <div class="text-white mb-8">
            <svg class="w-16 h-16 mx-auto mb-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ingin Mengetahui Lebih Lanjut?</h2>
            <p class="text-lg text-white/90 max-w-2xl mx-auto">Jelajahi informasi lengkap tentang SD Negeri 2 Dermolo dan temukan mengapa kami menjadi pilihan terbaik untuk pendidikan putra-putri Anda</p>
        </div>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full bg-white text-blue-600 font-bold hover:bg-blue-50 transition shadow-2xl hover:shadow-3xl text-lg">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
            </a>
            <a href="https://wa.me/6289668982633" target="_blank" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full bg-green-500 text-white font-bold hover:bg-green-600 transition shadow-2xl hover:shadow-3xl text-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
