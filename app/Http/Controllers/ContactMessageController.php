<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Mail\ContactReceivedMail;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Default subject if not provided
        if (empty($validated['subject'])) {
            $validated['subject'] = 'Pesan dari Kontak Website';
        }

        ContactMessage::create($validated);

        try {
            Mail::to('sdndermolo728@gmail.com')->send(new ContactReceivedMail($validated));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email kontak: ' . $e->getMessage());
            // We still proceed even if email fails, as it's saved in DB
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
    }
}
