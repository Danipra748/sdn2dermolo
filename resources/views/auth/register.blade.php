@extends('layouts.app')

@section('title', 'Register - SD N 2 Dermolo')

@section('content')
<section class="pt-32 pb-20 px-4 bg-gradient-to-br from-slate-100 to-blue-50 min-h-screen">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Daftar Akun</h1>
        <p class="text-sm text-slate-500 mb-6">Buat akun baru untuk mengelola data sekolah.</p>

        <form action="{{ route('register.attempt') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-slate-900 text-white py-2.5 text-sm font-semibold hover:opacity-90 transition">
                Daftar
            </button>

            <p class="text-center text-sm text-slate-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Masuk di sini</a>
            </p>
        </form>
    </div>
</section>
@endsection
