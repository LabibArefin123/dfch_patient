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

    public function doc_3()
    {
        return view('frontend.welcome_page.doctor.doc_3');
    }

    public function doc_4()
    {
        return view('frontend.welcome_page.doctor.doc_4');
    }

    public function doc_5()
    {
        return view('frontend.welcome_page.doctor.doc_5');
    }

    public function facility_1_emergency()
    {
        return view('frontend.welcome_page.facility.page_1_emergency');
    }

}
