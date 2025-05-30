<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RequestController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required|string',
            // 'phone' => 'required|string',
            // 'email' => 'nullable|email',

            'width' => 'required|numeric',
            'length' => 'required|numeric',
            'height' => 'required|numeric',
            'post_thickness' => 'required|numeric',
            'frame_type' => 'required|string',

            'area' => 'required|numeric',
            'materials' => 'required|numeric',
            'consumables' => 'required|numeric',
            'manufacturing' => 'required|numeric',
            'installation' => 'required|numeric',
            'delivery' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'final' => 'required|numeric',
            'per_m2' => 'required|numeric',
        ]);

        $user = auth()->user();

        DB::table('requests')->insert([
            'user_id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,

            'width' => $request->width,
            'length' => $request->length,
            'height' => $request->height,
            'post_thickness' => $request->post_thickness,
            'frame_type' => $request->frame_type,

            'area' => $request->area,
            'materials' => $request->materials,
            'consumables' => $request->consumables,
            'manufacturing' => $request->manufacturing,
            'installation' => $request->installation,
            'delivery' => $request->delivery,
            'discount' => $request->discount,
            'total' => $request->total,
            'final_price' => $request->final,
            'per_m2' => $request->per_m2,

            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return response()->json(['success' => true]);
        // return redirect()->back()->with('success', 'Заявка успешно отправлена!');
    }

    public function downloadPdf(Request $request)
    {
        $data = $request->all();
        // print_r($data);
        $pdf = Pdf::loadView('pdf.calculation', ['data' => $data]);

        // return view('pdf.calculation', ['data' => $data]);
        return $pdf->download('naves-raschet.pdf');
    }

    public function myReports()
    {
        $requests = DB::table('requests')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('requests.my', compact('requests'));
    }

}
