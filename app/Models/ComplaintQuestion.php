<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplaintQuestion extends Model
{
    use SoftDeletes;
    public const TYPE_TEXT = 'text';

    public const TYPE_TEXTAREA = 'textarea';

    public const TYPE_EMAIL = 'email';

    public const TYPE_PHONE = 'phone';

    public const TYPE_SELECTION = 'selection';

    public const TYPE_BOOLEAN = 'boolean';

    public const TYPE_FILE = 'file';

    protected $fillable = [
        'prompt',
        'prompt_bn',
        'type',
        'allow_multiple',
        'sort_order',
        'is_active',
        'is_filterable',
    ];

    protected function casts(): array
    {
        return [
            'allow_multiple' => 'boolean',
            'is_active' => 'boolean',
            'is_filterable' => 'boolean',
        ];
    }

    public function options(): HasMany
    {
        return $this->hasMany(ComplaintQuestionOption::class)->orderBy('sort_order');
    }

    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
