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

    public function facility_2_icu()
    {
        return view('frontend.welcome_page.facility.page_2_icu');
    }

    public function facility_3_ot()
    {
        return view('frontend.welcome_page.facility.page_3_ot');
    }

    public function facility_4_post_op()
    {
        return view('frontend.welcome_page.facility.page_4_post_operative_room');
    }

    public function facility_5_ward()
    {
        return view('frontend.welcome_page.facility.page_5_ward');
    }

    public function facility_6_cabin()
    {
        return view('frontend.welcome_page.facility.page_6_private_cabin');
    }

    public function facility_7_laboratory()
    {
        return view('frontend.welcome_page.facility.page_7_laboratory');
    }

    public function facility_8_radiology_and_image()
    {
        return view('frontend.welcome_page.facility.page_8_radiology_and_image');
    }

}
