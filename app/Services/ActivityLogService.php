<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    /**
     * Log an activity in the database.
     *
     * @param string $userId
     * @param string $action
     * @param string $entity
     * @param array $details
     * @return void
     */
    public function logActivity(string $userId, string $action, string $entity, array $details = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity' => $entity,
            'details' => json_encode($details),
            'performed_at' => now(),
        ]);
    }
}
