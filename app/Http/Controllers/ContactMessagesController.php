<?php

namespace App\Http\Controllers;

use App\Models\ContactMessages;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{
    public function create()
    {
        return view('contact_us');
    }

    // Store the contact message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'email' => 'required|email',
        ]);

        ContactMessages::create([
            'message' => $request->message,
            'problem' => $request->problem,
            'email' => $request->email,
            'user_id' => $request->user_id, // Nullable
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // View all contact messages
    public function index()
    {
        $messages = ContactMessages::latest()->paginate(10);
        return view('admin.dashboard.contacts', compact('messages'));
    }
}
