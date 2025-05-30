<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalcController extends Controller
{
    public function index()
    {
        $settings = DB::table('canopy_pricing_settings')->first();

        return view('admin.calc.index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'base_price_per_m2' => 'required|numeric|min:0',
            'materials_coef' => 'required|numeric|min:0',
            'consumables_coef' => 'required|numeric|min:0',
            'manufacturing_coef' => 'required|numeric|min:0',
            'installation_coef' => 'required|numeric|min:0',
            'delivery_price' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        DB::table('canopy_pricing_settings')->updateOrInsert(
            ['id' => 1],
            [
                'base_price_per_m2' => $request->base_price_per_m2,
                'materials_coef' => $request->materials_coef,
                'consumables_coef' => $request->consumables_coef,
                'manufacturing_coef' => $request->manufacturing_coef,
                'installation_coef' => $request->installation_coef,
                'delivery_price' => $request->delivery_price,
                'discount_amount' => $request->discount_amount,
                'updated_at' => now(),
            ]
        );

        return redirect()->route('admin.calc.index')->with('success', 'Настройки успешно обновлены.');
    }
}