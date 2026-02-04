<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    public function index()
    {
        return view('frontend.welcome');
    }

    public function doc_1()
    {
        return view('frontend.welcome_page.doctor.doc_1');
    }

    public function doc_2()
    {
        return view('frontend.welcome_page.doctor.doc_2');
    }

    public function help()
    {
        return view('frontend.welcome_page.public.help');
    }
}
