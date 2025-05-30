<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CrmLead;

class CrmLeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = CrmLead::latest()->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }
}
