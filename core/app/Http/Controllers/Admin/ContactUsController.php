<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display the contact info.
     */
    public function index()
    {
        $contactUs = ContactUs::first();
        return view('admin.contact.index', compact('contactUs'));
    }

    /**
     * Show the form for creating a new contact info.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created contact info in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'working_days' => 'required',
        ]);

        ContactUs::create($request->only('address', 'phone', 'email', 'working_days'));

        return redirect()->route('admin.contact.index')
                ->with('success', 'Contact info saved successfully!');
    }

    /**
     * Show the form for editing the contact info.
     */
    public function edit(ContactUs $contactUs)
    {
        return view('admin.contact.edit', compact('contactUs'));
    }

    /**
     * Update the specified contact info in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'working_days' => 'required',
        ]);

        $contactUs->update($request->only('address', 'phone', 'email', 'working_days'));

        return redirect()->route('admin.contact.index')
                ->with('success', 'Contact info updated successfully!');
    }

    /**
     * Remove the specified contact info from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        $contactUs->delete();

        return redirect()->route('admin.contact.index')
                ->with('success', 'Contact info deleted successfully!');
    }
}
