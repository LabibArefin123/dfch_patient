<?php

namespace App\Http\Controllers;

use App\Models\PatientDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientDraftController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Create / Update Draft
    |--------------------------------------------------------------------------
    */

    public function save(Request $request)
    {
        $request->validate([
            'draft_token' => ['required', 'uuid'],
            'form_data' => ['required', 'array'],
            'current_step' => ['nullable', 'string'],
        ]);

        $draft = PatientDraft::updateOrCreate(
            [
                'draft_token' => $request->draft_token,
                'user_id' => auth()->id(),
            ],
            [
                'form_data' => $request->form_data,
                'current_step' => $request->current_step,
                'last_saved_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'saved_at' => $draft->last_saved_at?->toISOString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Pending Drafts
    |--------------------------------------------------------------------------
    */

    public function pending()
    {
        $drafts = PatientDraft::where('user_id', auth()->id())
            ->orderByDesc('last_saved_at')
            ->get();

        return response()->json([
            'count' => $drafts->count(),

            'drafts' => $drafts->map(function ($draft) {
                return [
                    'id' => $draft->id,
                    'draft_token' => $draft->draft_token,
                    'current_step' => $draft->current_step,
                    'last_saved_at' => $draft->last_saved_at?->toISOString(),
                ];
            }),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Get One Draft
    |--------------------------------------------------------------------------
    */

    public function show(PatientDraft $draft)
    {
        abort_unless(
            $draft->user_id === auth()->id(),
            403
        );

        return response()->json([
            'success' => true,
            'draft' => [
                'id' => $draft->id,
                'draft_token' => $draft->draft_token,
                'form_data' => $draft->form_data,
                'current_step' => $draft->current_step,
                'last_saved_at' => $draft->last_saved_at?->toISOString(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Draft
    |--------------------------------------------------------------------------
    */

    public function destroy(PatientDraft $draft)
    {
        abort_unless(
            $draft->user_id === auth()->id(),
            403
        );

        $draft->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
