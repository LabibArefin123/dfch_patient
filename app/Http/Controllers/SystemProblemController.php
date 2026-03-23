<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemProblem;
use Yajra\DataTables\DataTables;
use App\Notifications\SystemProblemNotification;
use Illuminate\Support\Facades\Notification;

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

                ->editColumn('status_email', function ($row) {
                    return $row->status_email ?
                        '<span class="badge bg-info">' . $row->status_email . '</span>' :
                        '<span class="text-muted">Not Notified</span>';
                })
                ->editColumn('remarks', function ($row) {
                    return $row->remarks ? e($row->remarks) : 'N/A';
                })
                ->addColumn('notify', function ($row) {

                    if ($row->status_email === 'Sent') {

                        $time = $row->updated_at
                            ? $row->updated_at->format('d M Y, h:i A')
                            : 'N/A';

                        return '<span class="badge bg-success"
                    data-bs-toggle="tooltip"
                    title="Sent at: ' . $time . '">
                    Already Sent
                </span>';
                    }

                    return '<button class="btn btn-sm btn-success notify-btn"
                data-id="' . $row->id . '">
                <i class="fas fa-paper-plane"></i> Notify
            </button>';
                })
                // Attachments column (images & PDFs)
                ->editColumn('problem_file', function ($row) {
                    $attachments = [];

                    if ($row->problem_file) {
                        $attachments[] = ['name' => $row->problem_file, 'type' => pathinfo($row->problem_file, PATHINFO_EXTENSION)];
                    }
                    if (!empty($row->multiple_images) && is_array($row->multiple_images)) {
                        foreach ($row->multiple_images as $img) {
                            if ($img) $attachments[] = ['name' => $img, 'type' => pathinfo($img, PATHINFO_EXTENSION)];
                        }
                    }
                    if (!empty($row->multiple_pdfs) && is_array($row->multiple_pdfs)) {
                        foreach ($row->multiple_pdfs as $pdf) {
                            if ($pdf) $attachments[] = ['name' => $pdf, 'type' => pathinfo($pdf, PATHINFO_EXTENSION)];
                        }
                    }

                    $html = '';
                    foreach ($attachments as $file) {
                        $ext = strtolower($file['type']);
                        $name = $file['name'];

                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $filePath = asset('uploads/problem/images/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank"><img src="' . $filePath . '" style="max-height:40px;margin:2px;" class="img-thumbnail"></a>';
                        } elseif ($ext === 'pdf') {
                            $filePath = asset('uploads/problem/files/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-file-pdf"></i></a>';
                        } else {
                            $filePath = asset('uploads/problem/files/' . $name);
                            $html .= '<a href="' . $filePath . '" target="_blank" class="btn btn-sm btn-outline-secondary me-1"><i class="fas fa-file"></i></a>';
                        }
                    }
                    return $html ?: '<span class="text-muted">No attachments</span>';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y, h:i A');
                })

                ->addColumn('action', function ($row) {
                    return '<a href="' . route('system_problems.show', $row->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
                })

                ->rawColumns(['status', 'status_email', 'problem_file', 'notify', 'action'])
                ->make(true);
        }

        return view('backend.setting_management.system_problem.index');
    }

    public function notify($id)
    {
        $problem = SystemProblem::findOrFail($id);

        // Always send to your email
        Notification::route('mail', 'mdlabibarefin@gmail.com')
            ->notify(new SystemProblemNotification($problem));

        // Optional: update status_email column
        $problem->update([
            'status_email' => 'Sent'
        ]);

        return response()->json(['success' => true]);
    }

    public function saveRemarks(Request $request, $id)
    {
        $problem = SystemProblem::findOrFail($id);

        // Generate remarks
        if ($request->type === 'solved') {
            $remarks = '✅ This issue has been resolved successfully.';

            // Optional: auto update status
            $problem->status = 'low';
        } else {
            $remarks = $request->custom;
        }

        $problem->remarks = $remarks;
        $problem->save();

        return response()->json(['success' => true]);
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
