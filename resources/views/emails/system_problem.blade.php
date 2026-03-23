@component('mail::message')
    # 🚨 System Issue Notification

    A system issue has been recorded in the monitoring system. Please review the details below:

    ---

    ### 🔎 Issue Summary
    - **Problem ID:** {{ $problem->problem_uid }}
    - **Title:** {{ $problem->problem_title }}
    - **Priority Level:** {{ ucfirst($problem->status) }}
    - **Reported On:** {{ $problem->created_at->format('d M Y, h:i A') }}

    ---

    ### 📝 Description
    {{ $problem->problem_description }}

    @if ($remarks)
        ---

        ### 💬 System Assessment
        {{ $remarks }}
    @endif

    ---

    @component('mail::button', ['url' => route('system_problems.show', $problem->id)])
        View Full Details
    @endcomponent

    ---

    If this issue is critical, immediate action is recommended.

    Thanks & Regards,
    **{{ config('app.name') }}**
    _System Monitoring & Alert Service_
@endcomponent
