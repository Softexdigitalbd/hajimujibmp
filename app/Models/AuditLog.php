<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public const ACTION_STATUS_CHANGED = 'status_changed';

    public const ACTION_COMMENT_ADDED = 'comment_added';

    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'user_id',
        'action',
        'from_complaint_status_id',
        'to_complaint_status_id',
        'comment_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'from_complaint_status_id');
    }

    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'to_complaint_status_id');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
