<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index()
    {
        $requests = DB::table('requests')->orderByDesc('created_at')->paginate(20);

        return view('admin.requests.index', compact('requests'));
    }
}
