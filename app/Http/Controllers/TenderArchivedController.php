<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TenderArchive;
use Yajra\DataTables\DataTables;

class TenderArchivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archivedTenders = Tender::query()
            ->where(function ($query) {
                $query->archived()
                    ->orWhere('status', 4); // Completed
            })
            ->get();

        return view('backend.tender.archived.index', compact('archivedTenders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
