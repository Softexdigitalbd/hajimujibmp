<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintQuestionOption extends Model
{
    protected $fillable = [
        'complaint_question_id',
        'label',
        'sort_order',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(ComplaintQuestion::class, 'complaint_question_id');
    }
}
