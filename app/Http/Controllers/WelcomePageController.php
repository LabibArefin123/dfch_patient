<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\SystemProblem;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function facility_9_ecg()
    {
        return view('frontend.welcome_page.facility.page_9_ecg');
    }

    public function facility_10_colonoscopy()
    {
        return view('frontend.welcome_page.facility.page_10_colonoscopy');
    }

    public function facility_11_pharmacy()
    {
        return view('frontend.welcome_page.facility.page_11_pharmacy');
    }

    public function facility_12_emergency()
    {
        return view('frontend.welcome_page.facility.page_12_emergency');
    }

    public function system_problem_store(Request $request)
    {
        $request->validate([
            'problem_title'       => 'required|string|max:255',
            'problem_description' => 'required|string',
            'status'              => 'required|in:low,medium,high,critical',
            'problem_file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:4096',
        ]);

        // Generate readable unique ID
        $uid = 'DFCH-PROB-' . strtoupper(Str::random(6));

        $fileName = null;

        if ($request->hasFile('problem_file')) {

            $file      = $request->file('problem_file');
            $extension = $file->getClientOriginalExtension();
            $original  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Time format: HHMMSS_DDMMYY
            $timeStamp = Carbon::now()->format('His_dmy');

            // Clean filename
            $fileName = Str::slug($original) . '_' . $timeStamp . '.' . $extension;

            // Decide folder
            $imageExt = ['jpg', 'jpeg', 'png'];
            $folder   = in_array(strtolower($extension), $imageExt)
                ? 'uploads/problem/images'
                : 'uploads/problem/files';

            // Move file
            $file->move(public_path($folder), $fileName);
        }

        SystemProblem::create([
            'problem_uid'        => $uid,
            'problem_title'      => $request->problem_title,
            'problem_description' => $request->problem_description,
            'status'             => $request->status,
            'problem_file'       => $fileName, // only filename saved
        ]);

        return back()->with('success', '✅ Your problem has been submitted successfully.');
    }
}
