<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::all();
        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        Portfolio::create($validated);

        return redirect()->route('portfolio.index')->with('success', 'Работа добавлена.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Удалить старое изображение, если есть
            if ($portfolio->image) {
                \Storage::disk('public')->delete($portfolio->image);
            }

            // Сохранить новое
            $imagePath = $request->file('image')->store('uploads/portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        // Обновляем именно эту запись
        $portfolio->update($validated);

        return redirect()->route('portfolio.index')->with('success', 'Работа обновлена.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Работа удалена.');
    }
}
