<?php

namespace App\Http\Controllers;

use App\Models\TenderAwarded;
use App\Models\PerformanceGuarantee;
use Illuminate\Http\Request;


class PGController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pg = TenderAwarded::with(['pg', 'tenderParticipate.tender'])->findOrFail($id);

        return view('backend.tender.pg.show', compact('pg'));
    }

    public function destroy($id)
    {
        $pg = PerformanceGuarantee::findOrFail($id);

        // Optionally delete the file too
        if ($pg->attachment && file_exists(public_path('uploads/documents/pg_attachments/' . $pg->attachment))) {
            unlink(public_path('uploads/documents/pg_attachments/' . $pg->attachment));
        }

        $pg->delete();

        return redirect()->back()->with('success', 'Performance Guarentee (PG) deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
