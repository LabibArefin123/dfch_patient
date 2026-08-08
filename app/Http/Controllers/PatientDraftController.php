<?php

namespace App\Http\Controllers;

use App\Models\PatientDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDraftController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Create / Update Draft
    |--------------------------------------------------------------------------
    */

    public function save(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Require authenticated user
        |--------------------------------------------------------------------------
        */

        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'draft_token'  => ['required', 'uuid'],
            'form_data'    => ['required', 'array'],
            'current_step' => ['nullable', 'string'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create / Update User's Draft
        |--------------------------------------------------------------------------
        |
        | draft_token + user_id ensures that:
        |
        | User A cannot update User B's draft.
        |
        */

        $draft = PatientDraft::updateOrCreate(
            [
                'draft_token' => $request->draft_token,
                'user_id'     => $user->id,
            ],
            [
                'form_data'    => $request->form_data,
                'current_step' => $request->current_step,
                'last_saved_at' => now(),
            ]
        );

        return response()->json([
            'success'   => true,
            'draft_id'  => $draft->id,
            'draft_token' => $draft->draft_token,
            'saved_at'  => $draft->last_saved_at?->toISOString(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Get Pending Drafts
    |--------------------------------------------------------------------------
    */

    public function pending()
    {
        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Only this user's drafts
        |--------------------------------------------------------------------------
        */

        $drafts = PatientDraft::where(
                'user_id',
                $user->id
            )
            ->orderByDesc('last_saved_at')
            ->get();

        return response()->json([
            'success' => true,
            'count'   => $drafts->count(),

            'drafts' => $drafts->map(function ($draft) {

                return [
                    'id'           => $draft->id,
                    'draft_token'  => $draft->draft_token,
                    'current_step' => $draft->current_step,
                    'last_saved_at' => $draft->last_saved_at?->toISOString(),
                ];

            })->values(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Get One Draft
    |--------------------------------------------------------------------------
    */

    public function show(PatientDraft $draft)
    {
        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Security:
        | User can only open their own draft
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $draft->user_id === (int) $user->id,
            403
        );

        return response()->json([
            'success' => true,

            'draft' => [
                'id'            => $draft->id,
                'draft_token'   => $draft->draft_token,
                'form_data'     => $draft->form_data,
                'current_step'  => $draft->current_step,
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
        abort_unless(Auth::check(), 401);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Security:
        | User can only delete their own draft
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $draft->user_id === (int) $user->id,
            403
        );

        $draft->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient draft deleted successfully.',
        ]);
    }
}
