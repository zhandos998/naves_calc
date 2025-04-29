<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalcController extends Controller
{
    public function index()
    {
        return view('user.calc');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'width' => 'required|numeric|min:1',
            'length' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'material' => 'required|string',
            'covering' => 'required|string',
        ]);

        $area = $validated['width'] * $validated['length'];

        $basePricePerM2 = 12000; // базовая цена за м²
        $materialCoef = match ($validated['material']) {
            'металл' => 1.0,
            'поликарбонат' => 1.1,
            'профнастил' => 0.9,
            default => 1,
        };

        $coveringCoef = match ($validated['covering']) {
            'обычный' => 1.0,
            'усиленный' => 1.2,
            default => 1,
        };

        $price = $area * $basePricePerM2 * $materialCoef * $coveringCoef;

        return back()->with('result', round($price));
    }
}
