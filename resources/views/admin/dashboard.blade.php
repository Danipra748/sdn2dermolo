@extends('admin.layout')

@section('title', 'Dashboard')

@section('heading', 'Dashboard Insights')

@section('content')
    {{-- Status Session --}}
    @if (session('status'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm font-bold animate-in fade-in slide-in-from-top-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Top Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stat-card 
            title="Total Guru & Staf" 
            :value="$stats['total_guru']" 
            description="Tenaga Pendidik Aktif"
            color="blue">
            <x-slot:icon><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg></x-slot:icon>
        </x-admin.stat-card>

        <x-admin.stat-card 
            title="Berita Sekolah" 
            :value="$stats['published_articles'] ?? 0" 
            :description="($stats['draft_articles'] ?? 0) . ' Draft tersimpan'"
            color="green">
            <x-slot:icon><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg></x-slot:icon>
        </x-admin.stat-card>

        <x-admin.stat-card 
            title="Pesan Masuk" 
            :value="$stats['total_messages'] ?? 0" 
            :description="($stats['unread_messages'] ?? 0) . ' Pesan baru'"
            color="amber">
            <x-slot:icon><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg></x-slot:icon>
        </x-admin.stat-card>

        <x-admin.stat-card 
            title="Fasilitas Sekolah" 
            :value="$stats['total_fasilitas']" 
            description="Terawat dengan baik"
            color="purple">
            <x-slot:icon><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1M2.25 15l4.5-2m0 0V3l4.5-1.636M12.75 21V10.75m0 0L21.25 7.5M12.75 10.75V3l4.5-1.636"/></svg></x-slot:icon>
        </x-admin.stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Charts Section --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Grafik Kunjungan Berita</h3>
                        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mt-1">Aktivitas 7 Hari Terakhir</p>
                    </div>
                    <div class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-200 text-[0.65rem] font-bold text-slate-600">VIEW COUNT</div>
                </div>
                <div class="h-[350px] w-full relative">
                    <canvas id="newsChart"></canvas>
                </div>
            </div>

            <div class="glass-card overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Artikel Terbaru</h3>
                    <x-admin.button variant="ghost" size="sm" href="{{ route('admin.articles.index') }}">
                        Lihat Semua →
                    </x-admin.button>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recentArticles as $article)
                        <div class="p-5 flex items-center justify-between hover:bg-slate-50/80 transition group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-1">{{ $article->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <x-admin.badge :variant="$article->status === 'published' ? 'success' : 'warning'">
                                            {{ $article->status }}
                                        </x-admin.badge>
                                        <span class="text-[0.65rem] text-slate-400">{{ $article->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <x-admin.button variant="outline" size="sm" href="{{ route('admin.articles.edit', $article) }}" class="opacity-0 group-hover:opacity-100">
                                Edit
                            </x-admin.button>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm italic">Belum ada artikel.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar Stats --}}
        <div class="space-y-8">
            <div class="glass-card p-8 bg-slate-950 text-white border-none shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <h3 class="text-base font-bold mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    Informasi Sistem
                </h3>
                <div class="space-y-6">
                    <div class="flex justify-between items-end border-b border-white/5 pb-4">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">Waktu Server</span>
                        <span class="text-sm font-bold">{{ now()->format('H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between items-end border-b border-white/5 pb-4">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">Status Web</span>
                        <x-admin.badge variant="success" class="!bg-emerald-500/20 !text-emerald-400 !border-none">ONLINE</x-admin.badge>
                    </div>
                    <div class="flex justify-between items-end border-b border-white/5 pb-4">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest">Laravel</span>
                        <span class="text-sm font-bold">v12.x</span>
                    </div>
                </div>
                <div class="mt-8">
                    <p class="text-[0.65rem] text-slate-500 font-medium leading-relaxed">
                        Seluruh data di dashboard ini diperbarui secara otomatis berdasarkan aktivitas website secara real-time.
                    </p>
                </div>
            </div>

            <div class="glass-card p-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Pesan Belum Dibaca</h3>
                <div class="space-y-4">
                    @if(isset($stats['unread_messages']) && $stats['unread_messages'] > 0)
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100">
                            <p class="text-sm text-amber-900 leading-relaxed font-medium">
                                Ada <span class="font-black underline">{{ $stats['unread_messages'] }} pesan baru</span> yang belum dibalas dari formulir kontak.
                            </p>
                            <x-admin.button variant="secondary" size="sm" href="{{ route('admin.messages.index') }}" class="mt-4 w-full !bg-white">
                                Balas Sekarang
                            </x-admin.button>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Semua pesan terbaca</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('newsChart').getContext('2d');
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'News Views',
                    data: chartData.data,
                    fill: true,
                    borderColor: '#0EA5E9',
                    backgroundColor: 'rgba(14, 165, 233, 0.05)',
                    borderWidth: 3,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#0EA5E9',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        padding: 12,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9' },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#94A3B8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#94A3B8' }
                    }
                }
            }
        });
    });
</script>
@endpush
