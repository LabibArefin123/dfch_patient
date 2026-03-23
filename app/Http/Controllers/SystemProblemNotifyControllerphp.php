<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SystemProblemMail;
use App\Models\SystemProblem;
use Illuminate\Http\Request;

class SystemProblemNotifyController extends Controller
{
    public function sendEmail(SystemProblem $systemProblem, Request $request)
    {
        $request->validate([
            'to_email' => 'required|email',
            'remarks' => 'nullable|string|max:1000'
        ]);

        // Send email via Mailable
        Mail::to($request->to_email)->send(new SystemProblemMail($systemProblem, $request->remarks));

        // Update status & remarks
        $systemProblem->update([
            'status_email' => 'Email sent successfully, waiting for developer response',
            'remarks' => $request->remarks ?? null,
        ]);

        return back()->with('success', '✅ Email sent successfully!');
    }
}