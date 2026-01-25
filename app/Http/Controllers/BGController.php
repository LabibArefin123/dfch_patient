<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenderParticipate;
use App\Models\BigGuarantee;

class BGController extends Controller
{
    public function show($id)
    {
        $bg = TenderParticipate::with(['bg', 'tender'])->findOrFail($id);

        return view('backend.tender.bg.show', compact('bg'));
    }

    public function destroy($id)
    {
        $bg = BigGuarantee::findOrFail($id);

        // Optionally delete the file too
        if ($bg->attachment && file_exists(public_path('uploads/documents/bg_attachments/' . $bg->attachment))) {
            unlink(public_path('uploads/documents/bg_attachments/' . $bg->attachment));
        }

        $bg->delete();

        return redirect()->back()->with('success', 'Bid Guarantee (BG) deleted successfully.');
    }
}
