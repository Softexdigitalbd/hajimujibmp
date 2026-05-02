<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintStatusTransition extends Model
{
    protected $fillable = [
        'from_complaint_status_id',
        'to_complaint_status_id',
    ];

    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'from_complaint_status_id');
    }

    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(ComplaintStatus::class, 'to_complaint_status_id');
    }
}
