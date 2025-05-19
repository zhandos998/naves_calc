<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrmLeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'email'   => 'nullable|email|max:255',
            'message' => 'required|string',
            'source'  => 'nullable|string|in:chat,calc,form',
        ]);

        $lead = \App\Models\CrmLead::create($data);

        return response()->json(['status' => 'ok', 'id' => $lead->id]);
    }
}
