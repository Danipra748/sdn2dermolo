<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;

class AdminContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Display the specified message.
     */
    public function show(ContactMessage $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
