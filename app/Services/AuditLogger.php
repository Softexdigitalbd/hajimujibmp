<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Complaint;

class AuditLogger
{
    public static function logStatusChange(
        Complaint $complaint,
        ?int $fromStatusId,
        int $toStatusId,
        ?int $userId,
    ): void {
        AuditLog::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => $userId,
            'action' => AuditLog::ACTION_STATUS_CHANGED,
            'from_complaint_status_id' => $fromStatusId,
            'to_complaint_status_id' => $toStatusId,
            'comment_id' => null,
            'created_at' => now(),
        ]);
    }

    public static function logComment(Complaint $complaint, int $commentId, int $userId): void
    {
        AuditLog::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => $userId,
            'action' => AuditLog::ACTION_COMMENT_ADDED,
            'from_complaint_status_id' => null,
            'to_complaint_status_id' => null,
            'comment_id' => $commentId,
            'created_at' => now(),
        ]);
    }
}
