<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    public function index(Request $request)
    {
        $query = Commodity::query();

        // Фильтрация
        if ($request->filled('material')) {
            $query->where('material', $request->material);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Сортировка
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $commodities = $query->paginate(12);

        return view('user.commodities.index', compact('commodities'));
    }

    public function show($id)
    {
        $commodity = Commodity::findOrFail($id);
        return view('user.commodities.show', compact('commodity'));
    }
}
