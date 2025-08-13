<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index()
    {
        $featuredCourses = Course::with(['chapters'])->latest()->take(6)->get();
        return view('home', compact('featuredCourses'));
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the courses listing page
     */
    public function courses()
    {
        $courses = Course::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('courses', compact('courses'));
    }

    /**
     * Show the about page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the terms page
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Show the privacy policy page
     */
    public function privacy()
    {
        return view('privacy');
    }
}
