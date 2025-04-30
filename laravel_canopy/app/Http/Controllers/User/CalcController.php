<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalcController extends Controller
{
    public function index()
    {
        return view('user.calc');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'width' => 'required|numeric|min:1',
            'length' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'post_thickness' => 'required|numeric',
            'frame_type' => 'required|string',
        ]);

        $settings = DB::table('canopy_pricing_settings')->first();

        $width = $request->input('width');
        $length = $request->input('length');
        $height = $request->input('height');
        $post_thickness = $request->input('post_thickness');
        $frame_type = $request->input('frame_type');

        $area = $width * $length;

        // Основной коэффициент по геометрии и конструкции
        $height_coef = 1 + (($height - 2.5) * 0.1); // каждый +10 см = +10%
        $post_coef = match ($post_thickness) {
            0.06 => 1.0,
            0.08 => 1.1,
            0.10 => 1.2,
            0.12 => 1.3,
            default => 1.0,
        };
        $frame_coef = match ($frame_type) {
            'arched' => 1.0,
            'half-arched' => 1.05,
            'single-slope' => 0.95,
            'triangular' => 1.15,
            'channel' => 1.2,
            'double-slope' => 1.25,
            default => 1.0,
        };

        $dynamic_price_per_m2 = $settings->base_price_per_m2 * $height_coef * $post_coef * $frame_coef;
        $base = $area * $dynamic_price_per_m2;

        $materials = $base * $settings->materials_coef;
        $consumables = $base * $settings->consumables_coef;
        $manufacturing = $base * $settings->manufacturing_coef;
        $installation = $base * $settings->installation_coef;
        $delivery = $settings->delivery_price;
        $discount = $settings->discount_amount;

        $total = $materials + $consumables + $manufacturing + $installation + $delivery;
        $final_price = $total - $discount;


        return back()->with([
            'calc_result' => [
                'area' => round($area, 2),
                'materials' => round($materials),
                'consumables' => round($consumables),
                'manufacturing' => round($manufacturing),
                'installation' => round($installation),
                'delivery' => round($delivery),
                'discount' => round($discount),
                'total' => round($total),
                'final' => round($final_price),
                'per_m2' => round($final_price / $area),
            ],
            'input' => [
                'width' => $width,
                'length' => $length,
                'height' => $height,
                'post_thickness' => $post_thickness,
                'frame_type' => $frame_type,
            ]
        ]);
    }

}
