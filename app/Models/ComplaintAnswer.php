<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintAnswer extends Model
{
    protected $fillable = [
        'complaint_id',
        'complaint_question_id',
        'value',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ComplaintQuestion::class, 'complaint_question_id');
    }
}
