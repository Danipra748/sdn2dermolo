@extends('admin.layout')

@section('title', 'Program Sekolah')
@section('heading', 'Manajemen Program Sekolah')

@section('content')
    <x-admin.page-header 
        title="Program & Ekstrakurikuler"
        subtitle="Kelola program unggulan dan kegiatan ekstrakurikuler sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.program-sekolah.create') }}" variant="primary" size="md">
                <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                Tambah Program
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.data-table 
        :headers="['Program', 'Highlight', 'Status', 'Aksi']"
        searchPlaceholder="Cari program..."
        id="programTable">
        
        @forelse($programs as $program)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-10 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                             @if($program->logo)
                                <img src="{{ asset('storage/' . $program->logo) }}" class="w-full h-full object-cover">
                            @elseif($program->foto)
                                <img src="{{ asset('storage/' . $program->foto) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ $program->title }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $program->created_at->isoFormat('D MMM YYYY') }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge :variant="$program->is_highlight ? 'info' : 'default'">
                        {{ $program->is_highlight ? 'Highlight' : 'Normal' }}
                    </x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge :variant="$program->is_active ? 'success' : 'danger'">
                        {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-admin.button variant="secondary" size="sm" href="{{ route('admin.program-sekolah.edit', $program) }}" title="Edit">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </x-admin.button>
                        <form action="{{ route('admin.program-sekolah.destroy', $program) }}" method="POST" data-confirm="Yakin ingin menghapus program ini?">
                            @csrf
                            @method('DELETE')
                            <x-admin.button type="submit" variant="destructive" size="sm" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 00-7.5 0"/></svg>
                            </x-admin.button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-20 text-center text-slate-400 italic">
                    Belum ada program sekolah yang ditambahkan.
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
