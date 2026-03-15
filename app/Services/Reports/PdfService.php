<?php

namespace App\Services\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Organization;
use Barryvdh\Snappy\Facades\SnappyPdf as SPDF;

class PdfService
{
    public function generatePdf(
        $query,
        Request $request,
        $smallView,
        $filename,
        $largeView = null
    ) {

        try {

            Log::info('PDF Generation Started', [
                'filename' => $filename,
                'request_params' => $request->all()
            ]);

            $query->orderBy('id');

            $perPage = 500;
            $page = $request->get('page', 1);
            $totalRecords = $query->count();
            $totalPages = ceil($totalRecords / $perPage);

            Log::info('PDF Record Count', [
                'totalRecords' => $totalRecords,
                'perPage' => $perPage,
                'totalPages' => $totalPages,
                'currentPage' => $page
            ]);

            if ($totalRecords === 0) {
                Log::warning('PDF Generation Aborted: No data found.');
                return back()->with('warning', 'No data found.');
            }

            if ($totalRecords > $perPage && !$request->filled('confirm')) {

                Log::info('PDF Confirmation Required', [
                    'totalRecords' => $totalRecords
                ]);

                return back()->with(array_merge(
                    [
                        'confirm_pdf'  => true,
                        'totalRecords' => $totalRecords,
                        'perPage'      => $perPage,
                    ],
                    $request->all()
                ));
            }

            // If largeView not provided, use smallView
            $largeView = $largeView ?? $smallView;

            // SMALL PDF
            if ($totalRecords <= 500) {

                Log::info('Generating SMALL PDF', [
                    'view' => $smallView
                ]);

                return $this->generateSmallPdf(
                    $query,
                    $smallView,
                    $filename,
                    $page,
                    $perPage,
                    $totalPages,
                    $totalRecords
                );
            }

            // LARGE PDF
            Log::info('Generating LARGE PDF', [
                'view' => $largeView
            ]);

            return $this->generateLargePdf(
                $query,
                $largeView,
                $filename,
                $page,
                $perPage,
                $totalPages,
                $totalRecords
            );
        } catch (\Exception $e) {

            Log::error('PDF Generation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'PDF generation failed. Check logs.');
        }
    }

    private function generateSmallPdf(
        $query,
        $view,
        $filename,
        $page,
        $perPage,
        $totalPages,
        $totalRecords
    ) {
        $patients = $query->limit($perPage)->get();
        $organization = Organization::first();
        $pdf = Pdf::loadView(
            $view,
            compact('patients', 'organization', 'page', 'perPage', 'totalPages', 'totalRecords')
        )->setPaper('a4', 'landscape');

        return $pdf->stream($filename);
    }

    private function generateLargePdf(
        $query,
        $view,
        $filename,
        $page,
        $perPage,
        $totalPages,
        $totalRecords
    ) {
        ini_set('memory_limit', '1024M');
        set_time_limit(600);

        $organization = Organization::first();

        $html = '';

        // Chunk data (VERY IMPORTANT)
        $query->chunk(500, function ($patients) use (
            &$html,
            $view,
            $organization,
            $page,
            $perPage,
            $totalPages,
            $totalRecords
        ) {
            $html .= view($view, compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            ))->render();
        });

        $pdf = SPDF::loadHTML($html)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('enable-local-file-access', true);

        return $pdf->stream($filename);
    }
    /* End of PDF GENERATOR  */
}
