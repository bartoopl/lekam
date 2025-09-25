<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index()
    {
        $featuredCourses = Course::with(['chapters'])->latest()->take(6)->get();
        $contents = Content::getPageContents('home');
        return view('welcome', compact('featuredCourses', 'contents'));
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

        $contents = Content::getPageContents('courses');

        return view('courses', compact('courses', 'contents'));
    }

    /**
     * Show the about page
     */
    public function about()
    {
        $contents = Content::getPageContents('about');
        return view('about', compact('contents'));
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

    /**
     * Show the cookies policy page
     */
    public function cookies()
    {
        return view('cookies');
    }
}
