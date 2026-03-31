@extends('admin.layout')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Pesan Masuk')
@section('heading', 'Pesan Masuk')

@section('content')
    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Kotak Masuk</h2>
                <p class="text-sm text-slate-500">Daftar pesan yang dikirim melalui formulir kontak.</p>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white/70">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold">Email</th>
                        <th class="px-4 py-3 text-left font-semibold">Subjek</th>
                        <th class="px-4 py-3 text-left font-semibold">Pesan</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $message->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $message->email }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $message->subject }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ Str::limit($message->message, 80) }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $message->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                                Belum ada pesan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </div>
@endsection
