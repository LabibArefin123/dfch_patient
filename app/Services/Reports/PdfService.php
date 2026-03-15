<?php

namespace App\Services\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as SPDF;
use App\Models\Organization;

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
                'params' => $request->all()
            ]);

            $perPage = 500;
            $page = $request->get('page', 1);

            // clone query before counting
            $countQuery = clone $query;
            $totalRecords = $countQuery->count();

            $totalPages = ceil($totalRecords / $perPage);

            Log::info('PDF Record Count', [
                'totalRecords' => $totalRecords,
                'perPage' => $perPage,
                'totalPages' => $totalPages
            ]);

            if ($totalRecords === 0) {

                Log::warning('PDF aborted: No records');

                return redirect()->back()->with('warning', 'No data found.');
            }

            // Confirmation for large exports
            if ($totalRecords > $perPage && !$request->filled('confirm')) {

                return redirect()->back()->with(array_merge(
                    [
                        'confirm_pdf' => true,
                        'totalRecords' => $totalRecords,
                        'perPage' => $perPage
                    ],
                    $request->all()
                ));
            }

            $largeView = $largeView ?? $smallView;

            if ($totalRecords <= $perPage) {

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

            return $this->generateLargePdf(
                $query,
                $largeView,
                $filename,
                $perPage,
                $totalPages,
                $totalRecords
            );
        } catch (\Throwable $e) {

            Log::error('PDF generation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()->with('error', 'PDF generation failed. Check logs.');
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
            compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream($filename);
    }


    private function generateLargePdf(
        $query,
        $view,
        $filename,
        $perPage,
        $totalPages,
        $totalRecords
    ) {

        ini_set('memory_limit', '1024M');
        set_time_limit(600);

        $organization = Organization::first();

        $html = '';
        $currentPage = 1;

        $query->chunkById(500, function ($patients) use (
            &$html,
            $view,
            $organization,
            &$currentPage,
            $perPage,
            $totalPages,
            $totalRecords
        ) {

            $page = $currentPage;

            $html .= view($view, compact(
                'patients',
                'organization',
                'page',
                'perPage',
                'totalPages',
                'totalRecords'
            ))->render();

            // page break
            $html .= '<div style="page-break-after: always;"></div>';

            $currentPage++;
        });

        $pdf = SPDF::loadHTML($html)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('enable-local-file-access', true)
            ->setOption('disable-smart-shrinking', true);

        return $pdf->stream($filename);
    }
}
