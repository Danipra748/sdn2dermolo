<x-mail::message>
# Pesan Baru Diterima

Halo Admin SD N 2 Dermolo,

Anda telah menerima pesan baru melalui formulir kontak website.

**Detail Pengirim:**
- **Nama:** {{ $data['name'] }}
- **Email:** {{ $data['email'] }}
- **Subjek:** {{ $data['subject'] ?? 'Pesan dari Kontak Website' }}

**Isi Pesan:**
{{ $data['message'] }}

<x-mail::button :url="'mailto:' . $data['email']">
Balas Email
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
