<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemProblemNotification extends Notification
{
    use Queueable;

    protected $problem;

    public function __construct($problem)
    {
        $this->problem = $problem;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $remarks = $this->generateRemarks($this->problem->status);

        return (new MailMessage)
            ->subject('🚨 System Problem Alert - ' . $this->problem->problem_uid)
            ->markdown('emails.system_problem', [
                'problem' => $this->problem,
                'remarks' => $remarks
            ]);
    }

    private function generateRemarks($status)
    {
        return match ($status) {
            'low' => 'This issue is minor and will be monitored.',
            'medium' => 'This issue requires attention and is being reviewed.',
            'high' => 'Urgent issue! Immediate action is recommended.',
            'critical' => 'Critical system failure! Immediate intervention required!',
            default => 'Status not defined.'
        };
    }
}
