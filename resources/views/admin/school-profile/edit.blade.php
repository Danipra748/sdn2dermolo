@extends('admin.layout')

@section('title', 'Profil Sekolah')
@section('heading', 'Profil Sekolah')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <div class="font-semibold">Error!</div>
            {{ session('error') }}
        </div>
    @endif

    {{-- Debug Info - Remove after fix is confirmed --}}
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <h4 class="font-bold text-sm">Debug Info:</h4>
        <p class="text-xs">Current logo path: <code class="bg-yellow-100 px-1">{{ $profile->logo ?? 'NULL' }}</code></p>
        <p class="text-xs">Profile ID: <code class="bg-yellow-100 px-1">{{ $profile->id ?? 'NULL' }}</code></p>
        <p class="text-xs">Fillable columns: <code class="bg-yellow-100 px-1">{{ implode(', ', $profile->getFillable()) }}</code></p>
    </div>

    <form action="{{ route('admin.school-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Dasar</h2>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $profile->school_name) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('school_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">NPSN</label>
                    <input type="text" name="npsn" value="{{ old('npsn', $profile->npsn) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('npsn')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Sekolah</label>
                    <select name="school_status" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="Negeri" {{ $profile->school_status === 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        <option value="Swasta" {{ $profile->school_status === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Akreditasi</label>
                    <select name="accreditation" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="A" {{ $profile->accreditation === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $profile->accreditation === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $profile->accreditation === 'C' ? 'selected' : '' }}>C</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Alamat & Lokasi</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('address', $profile->address) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Desa/Kelurahan</label>
                        <input type="text" name="village" value="{{ old('village', $profile->village) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kecamatan</label>
                        <input type="text" name="district" value="{{ old('district', $profile->district) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kabupaten/Kota</label>
                        <input type="text" name="city" value="{{ old('city', $profile->city) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province', $profile->province) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Kontak & Komunikasi</h2>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                           placeholder="(0291) 123-456"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                           placeholder="sdn2dermolo@gmail.com"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Website</label>
                    <input type="url" name="website" value="{{ old('website', $profile->website) }}"
                           placeholder="https://sdn2dermolo.sch.id"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- History & Stats --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Sejarah & Statistik</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Sejarah Sekolah</label>
                    <textarea name="history_content" rows="6" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('history_content', $profile->history_content) }}</textarea>
                    <p class="text-xs text-slate-500 mt-1">Ceritakan sejarah berdirinya sekolah secara singkat dan jelas.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Berdiri</label>
                        <input type="number" name="established_year" value="{{ old('established_year', $profile->established_year) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Luas Tanah</label>
                        <input type="text" name="land_area" value="{{ old('land_area', $profile->land_area) }}"
                               placeholder="1.400 m²"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Kelas</label>
                        <input type="number" name="total_classes" value="{{ old('total_classes', $profile->total_classes) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Vision & Mission --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Visi & Misi</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Visi Sekolah</label>
                    <textarea name="vision" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('vision', $profile->vision) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Misi Sekolah</label>
                    <p class="text-xs text-slate-500 mb-3">Isi setiap misi dalam kotak terpisah. Kosongkan jika tidak ada.</p>
                    
                    <div id="missions-container" class="space-y-3">
                        @php
                            $missions = old('mission_items', $profile->missions ?? []);
                            // Ensure we have at least 5 mission slots
                            while (count($missions) < 5) {
                                $missions[] = '';
                            }
                        @endphp
                        
                        @foreach($missions as $index => $mission)
                        <div class="mission-item flex gap-3">
                            <span class="flex items-center justify-center w-8 h-10 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm flex-shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <textarea name="mission_items[{{ $index }}]" rows="2" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ $mission }}</textarea>
                        </div>
                        @endforeach
                    </div>
                    
                    <button type="button" onclick="addMission()" class="mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-semibold">
                        <x-heroicon-o-plus class="w-4 h-4" />
                        Tambah Misi
                    </button>
                </div>
            </div>
        </div>

        {{-- School Logo --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Logo Sekolah</h2>
            
            <div class="flex items-start gap-6">
                @if($profile->logo)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo" class="w-32 h-32 object-contain rounded-xl border border-slate-200 bg-white p-2">
                        <button type="button" onclick="deleteLogo()" class="absolute -top-2 -right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                            <x-heroicon-o-trash class="w-4 h-4" />
                        </button>
                    </div>
                @endif
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload Logo</label>
                    <input type="file" name="logo" accept="image/*" onchange="previewLogo(event)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, SVG (Max 2MB)</p>
                    
                    @if($profile->logo)
                        <div id="logo-preview" class="mt-3 hidden">
                            <img id="logo-preview-img" src="" alt="Preview" class="w-32 h-32 object-contain rounded-xl border border-slate-200 bg-white p-2">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3 pb-8">
            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    let missionCount = {{ count($missions) }};

    function addMission() {
        missionCount++;
        const container = document.getElementById('missions-container');
        const newMission = document.createElement('div');
        newMission.className = 'mission-item flex gap-3';
        newMission.innerHTML = `
            <span class="flex items-center justify-center w-8 h-10 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm flex-shrink-0">
                ${missionCount}
            </span>
            <textarea name="mission_items[${missionCount - 1}]" rows="2" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Tulis misi ke-${missionCount}..."></textarea>
        `;
        container.appendChild(newMission);
    }

    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logo-preview');
                const previewImg = document.getElementById('logo-preview-img');
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function deleteLogo() {
        if (!confirm('Yakin ingin menghapus logo sekolah?')) return;
        
        fetch("{{ route('admin.school-profile.delete-logo') }}", {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
