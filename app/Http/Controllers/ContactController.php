<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $contents = Content::getPageContents('contact');
        return view('contact', compact('contents'));
    }
}
