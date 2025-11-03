<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(){
        $contact = ContactUs::first();
        return view('frontend.pages.contact-us.index', compact('contact'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName'  => 'required|string|max:50',
            'email'     => 'required|email',
            'phone'     => 'nullable|string|max:20',
            'subject'   => 'required|string|max:255',
            'body'      => 'required|string',
        ]);

        Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));

        return back()->with('success', '✅ Your message has been sent successfully!');
    }
}
