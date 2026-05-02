<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppSetting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'new_complaint_status_id',
        'reopen_status_id',
    ];

    public function newComplaintStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'new_complaint_status_id');
    }

    public function reopenStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'reopen_status_id');
    }

    public static function current(): self
    {
        return static::query()->with(['newComplaintStatus', 'reopenStatus'])->firstOrFail();
    }
}
