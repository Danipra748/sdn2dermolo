@extends('admin.layout')

@section('title', 'Pesan Masuk')
@section('heading', 'Kotak Masuk Pesan')

@section('content')
    <x-admin.page-header 
        title="Pesan & Pertanyaan"
        subtitle="Lihat dan balas pesan yang dikirim oleh pengunjung melalui formulir kontak."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>'>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.data-table 
        :headers="['Pengirim', 'Subjek Pesan', 'Tanggal', 'Aksi']"
        searchPlaceholder="Cari nama, email, atau subjek..."
        id="messagesTable">
        
        @forelse($messages as $message)
            <tr class="hover:bg-slate-50/50 transition {{ !$message->is_read ? 'bg-blue-50/50' : '' }}">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $message->name }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">{{ $message->email }}</div>
                </td>
                <td class="px-6 py-4">
                    <p class="font-bold text-slate-700 line-clamp-1">{{ $message->subject }}</p>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $message->message }}</p>
                </td>
                <td class="px-6 py-4 text-xs text-slate-500">
                    {{ $message->created_at->isoFormat('D MMM YYYY, HH:mm') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-admin.button variant="secondary" size="sm" href="{{ route('admin.messages.show', $message) }}" title="Lihat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </x-admin.button>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" data-confirm="Yakin ingin menghapus pesan dari {{ $message->name }}?">
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
                    Belum ada pesan masuk.
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>

    <div class="mt-8">
        {{ $messages->links() }}
    </div>
@endsection
