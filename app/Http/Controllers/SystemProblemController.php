<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemProblem;
use Yajra\DataTables\DataTables;

class SystemProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SystemProblem::latest();

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('status', function ($row) {
               
                    return '<span>' . ucfirst($row->status) . '</span>';
                })

                ->editColumn('problem_file', function ($row) {
                    if (!$row->problem_file) {
                        return '<span class="text-muted">No File</span>';
                    }

                    $ext = pathinfo($row->problem_file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);

                    $path = $isImage
                        ? asset('uploads/problem/images/' . $row->problem_file)
                        : asset('uploads/problem/files/' . $row->problem_file);

                    return '<a href="' . $path . '" target="_blank" class="btn btn-xs btn-info">
                            View
                        </a>';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y, h:i A');
                })

                ->addColumn('action', function ($row) {
                    return '
                    <a href="' . route('system_problems.show', $row->id) . '" 
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                ';
                })

                ->rawColumns(['status', 'problem_file', 'action'])
                ->make(true);
        }

        return view('backend.setting_management.system_problem.index');
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
    public function show(SystemProblem $systemProblem)
    {
        return view('backend.setting_management.system_problem.show', compact('systemProblem'));
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
