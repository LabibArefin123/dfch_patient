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

                // Status with badge
                ->editColumn('status', function ($row) {
                    $badge = match ($row->status) {
                        'low' => 'success',
                        'medium' => 'primary',
                        'high' => 'warning',
                        'critical' => 'danger',
                        default => 'secondary',
                    };
                    return '<span class="badge bg-' . $badge . '">' . ucfirst($row->status) . '</span>';
                })

                // Attachments column (supports single file, multiple images, multiple PDFs)
                ->editColumn('problem_file', function ($row) {
                    $attachments = [];

                    // Single file
                    if ($row->problem_file) {
                        $attachments[] = [
                            'name' => $row->problem_file,
                            'type' => pathinfo($row->problem_file, PATHINFO_EXTENSION),
                        ];
                    }

                    // Multiple images
                    if (!empty($row->multiple_images) && is_array($row->multiple_images)) {
                        foreach ($row->multiple_images as $img) {
                            if ($img) $attachments[] = [
                                'name' => $img,
                                'type' => pathinfo($img, PATHINFO_EXTENSION),
                            ];
                        }
                    }

                    // Multiple PDFs
                    if (!empty($row->multiple_pdfs) && is_array($row->multiple_pdfs)) {
                        foreach ($row->multiple_pdfs as $pdf) {
                            if ($pdf) $attachments[] = [
                                'name' => $pdf,
                                'type' => pathinfo($pdf, PATHINFO_EXTENSION),
                            ];
                        }
                    }

                    $html = '';
                    foreach ($attachments as $file) {
                        $ext = strtolower($file['type']);
                        $name = $file['name'];

                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $filePath = asset('uploads/problem/images/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank">
                                    <img src="' . $filePath . '" style="max-height:40px;margin:2px;" class="img-thumbnail">
                                  </a>';
                        } elseif ($ext === 'pdf') {
                            $filePath = asset('uploads/problem/files/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank" class="btn btn-sm btn-outline-info me-1">
                                    <i class="fas fa-file-pdf"></i>
                                  </a>';
                        } else {
                            $filePath = asset('uploads/problem/files/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="fas fa-file"></i>
                                  </a>';
                        }
                    }

                    return $html ?: '<span class="text-muted">No attachments</span>';
                })

                // Format reported date
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y, h:i A');
                })

                // Action buttons
                ->addColumn('action', function ($row) {
                    $show = '<a href="' . route('system_problems.show', $row->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
                    $edit = '<a href="' . route('system_problems.edit', $row->id) . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>';
                    return $show . ' ' . $edit;
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
