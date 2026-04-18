@extends('admin.layout')

@section('title', 'Detail Pesan')
@section('heading', 'Detail Pesan Masuk')

@section('content')
    <x-admin.page-header 
        title="Detail Pesan"
        subtitle="Dari: {{ $message->name }}">
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.messages.index') }}" variant="secondary" size="md">
                &larr; Kembali ke Kotak Masuk
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="glass-card p-8">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ $message->subject }}</h3>
                <div class="mt-8 prose prose-slate max-w-none leading-relaxed">
                    <p>{{ $message->message }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="glass-card p-6 space-y-4">
                <h3 class="font-bold">Detail Pengirim</h3>
                <div class="text-sm">
                    <div class="font-semibold text-slate-700">Nama</div>
                    <div class="text-slate-900">{{ $message->name }}</div>
                </div>
                <div class="text-sm">
                    <div class="font-semibold text-slate-700">Email</div>
                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:underline">{{ $message->email }}</a>
                </div>
                <div class="text-sm">
                    <div class="font-semibold text-slate-700">Tanggal</div>
                    <div class="text-slate-500">{{ $message->created_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }}</div>
                </div>
                <div class="pt-4 border-t border-slate-100">
                    <x-admin.button href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" variant="primary" size="md" class="w-full">
                        <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.47,19.28a.5.5,0,0,0,.7-.71L12.71,14H18a.5.5,0,0,0,0-1H12.71l4.47-4.57a.5.5,0,0,0-.71-.71L11.5,12.71V7a.5.5,0,0,0-1,0v5.71L5.93,8a.5.5,0,0,0-.71.71L9.71,13H4a.5.5,0,0,0,0,1H9.71l-4.47,4.57a.5.5,0,0,0,.7.71L11,14.71V20a.5.5,0,0,0,1,0V14.71Z"/></svg></x-slot:icon>
                        Balas via Email
                    </x-admin.button>
                </div>
            </div>
        </div>
    </div>
@endsection
