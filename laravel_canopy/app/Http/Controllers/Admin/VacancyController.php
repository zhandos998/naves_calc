<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();
        return view('admin.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('admin.vacancies.create');
    }

    public function store(Request $request)
    {
        Vacancy::create($request->only('title', 'description'));

        return redirect()->route('vacancies.index')->with('success', 'Вакансия добавлена.');
    }

    public function edit(Vacancy $vacancy)
    {
        return view('admin.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $vacancy->update($request->only('title', 'description'));

        return redirect()->route('vacancies.index')->with('success', 'Вакансия обновлена.');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return redirect()->route('vacancies.index')->with('success', 'Вакансия удалена.');
    }
}
