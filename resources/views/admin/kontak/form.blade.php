@extends('admin.layout')

@section('title', 'Kontak Sekolah')
@section('heading', 'Kontak Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Kontak</h2>
            <p class="text-sm text-slate-500">Isi alamat, telepon, email, dan lokasi sekolah pada peta.</p>
        </div>

        <form action="{{ route('admin.kontak.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Sekolah</label>
                <textarea name="address" rows="4"
                          class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300"
                          placeholder="Contoh: Desa Dermolo, Kecamatan Kembang&#10;Kabupaten Jepara, Jawa Tengah">{{ old('address', $kontak['address'] ?? '') }}</textarea>
                @error('address')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $kontak['phone'] ?? '') }}"
                           placeholder="Contoh: (0291) 123-456"
                           class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Sekolah</label>
                    <input type="email" name="email" value="{{ old('email', $kontak['email'] ?? '') }}"
                           placeholder="Contoh: sdn2dermolo@gmail.com"
                           class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tautan Google Maps (Opsional)</label>
                <input type="url" name="maps_url" value="{{ old('maps_url', $kontak['maps_url'] ?? '') }}"
                       placeholder="Contoh: https://maps.app.goo.gl/..."
                       class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('maps_url')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-500 mt-1">Tautan Google Maps untuk referensi (tidak ditampilkan di website).</p>
            </div>

            {{-- OpenStreetMap Interactive Section --}}
            <div class="mt-8">
                <label class="block text-sm font-medium text-slate-700 mb-2">📍 Lokasi Sekolah (OpenStreetMap)</label>
                <p class="text-xs text-slate-500 mb-3">
                    Klik pada peta untuk menempatkan pin, atau masukkan koordinat latitude & longitude manual.
                    Drag pin untuk menyesuaikan posisi.
                </p>
                
                <div class="grid md:grid-cols-3 gap-4">
                    {{-- Map Container - 2 columns --}}
                    <div class="md:col-span-2">
                        <div id="map" class="w-full rounded-2xl border-2 border-slate-300 shadow-lg" style="height: 100%; min-height: 400px;"></div>
                        <div class="mt-2 flex gap-2">
                            <button type="button" onclick="locateMe()" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                📍 Lokasi Saya
                            </button>
                            <button type="button" onclick="resetView()" class="px-3 py-1.5 rounded-lg bg-slate-600 text-white text-xs font-semibold hover:bg-slate-700 transition">
                                🔄 Reset Tampilan
                            </button>
                        </div>
                    </div>
                    
                    {{-- Coordinate Inputs - 1 column --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Latitude</label>
                            <input type="number" id="latitude" name="latitude" 
                                   value="{{ old('latitude', $kontak['latitude'] ?? -6.8283) }}" 
                                   step="0.000001" min="-90" max="90"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                   placeholder="-6.828300">
                            <p class="text-xs text-slate-500 mt-1">Range: -90 to 90</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Longitude</label>
                            <input type="number" id="longitude" name="longitude" 
                                   value="{{ old('longitude', $kontak['longitude'] ?? 110.6536) }}" 
                                   step="0.000001" min="-180" max="180"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                   placeholder="110.653600">
                            <p class="text-xs text-slate-500 mt-1">Range: -180 to 180</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Zoom Level</label>
                            <input type="number" id="zoom" name="zoom" 
                                   value="{{ old('zoom', $kontak['zoom'] ?? 15) }}" 
                                   min="1" max="19"
                                   class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                                   placeholder="15">
                            <p class="text-xs text-slate-500 mt-1">1 (zoom out) - 19 (zoom in)</p>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-200">
                            <div class="bg-blue-50 rounded-xl p-3 border border-blue-200">
                                <p class="text-xs text-blue-800 font-semibold mb-1"><i class="fas fa-lightbulb text-yellow-500"></i> Cara Menggunakan:</p>
                                <ol class="text-xs text-blue-700 space-y-1 list-decimal list-inside">
                                    <li>Klik peta untuk taruh pin</li>
                                    <li>Drag pin untuk geser posisi</li>
                                    <li>Atau input koordinat manual</li>
                                    <li>Scroll mouse untuk zoom</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-6 border-t border-slate-200">
                <button type="submit"
                        class="px-5 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Simpan Kontak
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Map state
    let map;
    let marker;
    let isMovingFromMap = false;
    
    // Default to Jepara center
    const defaultLat = {{ $kontak['latitude'] ?? -6.8283 }};
    const defaultLng = {{ $kontak['longitude'] ?? 110.6536 }};
    const defaultZoom = {{ $kontak['zoom'] ?? 15 }};
    
    // Initialize map
    function initMap() {
        // Create map
        map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);
        
        // Add OSM tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Add marker
        marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);
        
        // Handle map click
        map.on('click', function(e) {
            updateMarkerPosition(e.latlng.lat, e.latlng.lng);
        });
        
        // Handle marker drag
        marker.on('dragstart', function() {
            isMovingFromMap = true;
        });
        
        marker.on('dragend', function() {
            const latlng = marker.getLatLng();
            updateCoordinateInputs(latlng.lat, latlng.lng);
            isMovingFromMap = false;
        });
        
        // Handle zoom change
        map.on('zoomend', function() {
            document.getElementById('zoom').value = map.getZoom();
        });
    }
    
    // Update marker position
    function updateMarkerPosition(lat, lng) {
        marker.setLatLng([lat, lng]);
        updateCoordinateInputs(lat, lng);
    }
    
    // Update coordinate inputs
    function updateCoordinateInputs(lat, lng) {
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        
        // Trigger change event
        latInput.dispatchEvent(new Event('change'));
        lngInput.dispatchEvent(new Event('change'));
    }
    
    // Update marker from coordinates
    function updateMarkerFromCoords() {
        if (isMovingFromMap) return;
        
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        
        if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
            marker.setLatLng([lat, lng]);
            map.panTo([lat, lng]);
        }
    }
    
    // Get user's current location
    function locateMe() {
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung geolocation.');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                updateMarkerPosition(lat, lng);
                map.setView([lat, lng], 17);
            },
            () => {
                alert('Tidak dapat mendapatkan lokasi Anda. Pastikan GPS aktif dan izinkan akses lokasi.');
            }
        );
    }
    
    // Reset view to default
    function resetView() {
        map.setView([defaultLat, defaultLng], defaultZoom);
        updateCoordinateInputs(defaultLat, defaultLng);
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Add listeners to coordinate inputs
        document.getElementById('latitude').addEventListener('change', updateMarkerFromCoords);
        document.getElementById('longitude').addEventListener('change', updateMarkerFromCoords);
        document.getElementById('zoom').addEventListener('change', function() {
            const zoom = parseInt(this.value);
            if (!isNaN(zoom) && zoom >= 1 && zoom <= 19) {
                map.setZoom(zoom);
            }
        });
    });
</script>
@endpush
