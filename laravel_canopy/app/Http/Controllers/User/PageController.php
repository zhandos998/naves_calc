<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use App\Models\Vacancy;
use App\Models\Review;
use App\Models\Portfolio;

class PageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function about()
    {
        $about = About::first();
        return view('user.about', compact('about'));
    }

    public function contacts()
    {
        $contacts = Contact::first();
        return view('user.contacts', compact('contacts'));
    }

    public function vacancies()
    {
        $vacancies = Vacancy::all();
        return view('user.vacancies', compact('vacancies'));
    }

    public function reviews()
    {
        $reviews = Review::all();
        return view('user.reviews', compact('reviews'));
    }

    public function portfolio()
    {
        $portfolios = Portfolio::all();
        return view('user.portfolio', compact('portfolios'));
    }
}
