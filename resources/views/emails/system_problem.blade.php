@component('mail::message')
    # System Problem Notification

    **Problem ID:** {{ $problem->problem_uid }}
    **Title:** {{ $problem->problem_title }}
    **Priority:** {{ ucfirst($problem->status) }}

    **Description:**
    {{ $problem->problem_description }}

    @if ($remarks)
        **Remarks:**
        {{ $remarks }}
    @endif

    @component('mail::button', ['url' => route('system_problems.show', $problem->id)])
        View Problem
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
