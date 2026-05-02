<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    protected $fillable = [
        'public_reference',
        'complaint_status_id',
        'is_confidential',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'complaint_status_id')->withTrashed();
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ComplaintAnswer::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class)->orderBy('created_at');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
