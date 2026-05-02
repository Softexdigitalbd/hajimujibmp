<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\Complaint;
use App\Models\ComplaintStatus;
use App\Models\ComplaintStatusTransition;
use Illuminate\Validation\ValidationException;

class ComplaintTransitionService
{
    public function assertCanTransition(Complaint $complaint, int $toStatusId): void
    {
        $complaint->loadMissing('status');
        $from = $complaint->status;
        $to = ComplaintStatus::query()->where('is_active', true)->findOrFail($toStatusId);

        if ($from->id === $to->id) {
            throw ValidationException::withMessages([
                'complaint_status_id' => __('That status is already selected.'),
            ]);
        }

        $settings = AppSetting::query()->first();

        if ($from->state === ComplaintStatus::STATE_RESOLUTION && $to->state === ComplaintStatus::STATE_PROCESSING) {
            $reopenId = $settings?->reopen_status_id;
            if (! $reopenId || (int) $to->id !== (int) $reopenId) {
                throw ValidationException::withMessages([
                    'complaint_status_id' => __('Reopening must use the status chosen in Settings → Complaint behaviour.'),
                ]);
            }
        }

        $allowed = ComplaintStatusTransition::query()
            ->where('from_complaint_status_id', $from->id)
            ->where('to_complaint_status_id', $to->id)
            ->exists();

        if (! $allowed) {
            throw ValidationException::withMessages([
                'complaint_status_id' => __('That change is not allowed for this complaint.'),
            ]);
        }
    }

    public function transition(Complaint $complaint, int $toStatusId, int $userId): void
    {
        $this->assertCanTransition($complaint, $toStatusId);

        $fromId = $complaint->complaint_status_id;

        $complaint->update([
            'complaint_status_id' => $toStatusId,
        ]);

        AuditLogger::logStatusChange($complaint, $fromId, $toStatusId, $userId);
    }
}
