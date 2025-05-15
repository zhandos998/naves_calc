<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function edit()
    {
        $contacts = Contact::first();
        return view('admin.contacts.edit', compact('contacts'));
    }

    public function update(Request $request)
    {
        $contacts = Contact::first();
        $contacts->update($request->only('phone', 'email', 'address'));

        return redirect()->back()->with('success', 'Контакты обновлены.');
    }
}
