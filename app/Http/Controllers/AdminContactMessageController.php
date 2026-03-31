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
}
