<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    public function index()
    {
        $commodities = Commodity::latest()->paginate(10);
        return view('admin.commodities.index', compact('commodities'));
    }

    public function create()
    {
        return view('admin.commodities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'size' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/commodities', 'public');
        }

        Commodity::create($validated);

        return redirect()->route('admin.commodities.index')->with('success', 'Товар добавлен.');
    }

    public function edit(Commodity $commodity)
    {
        return view('admin.commodities.edit', compact('commodity'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'size' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images/commodities', 'public');
        }

        $commodity->update($validated);

        return redirect()->route('admin.commodities.index')->with('success', 'Товар обновлен.');
    }

    public function destroy(Commodity $commodity)
    {
        if ($commodity->image) {
            \Storage::disk('public')->delete($commodity->image);
        }

        $commodity->delete();

        return redirect()->route('admin.commodities.index')->with('success', 'Товар удален.');
    }
}
