<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComplaintStatus extends Model
{
    use SoftDeletes;
    public const STATE_STARTED = 'Started';

    public const STATE_PROCESSING = 'Processing';

    public const STATE_RESOLUTION = 'Resolution';

    protected $fillable = [
        'name',
        'alias_name',
        'state',
        'color',
        'sort_order',
        'is_active',
    ];

    public function colorClasses(): array
    {
        $hex = $this->color;
        
        // Fallback backward compatibility map for old string seeds if any remain
        $legacyMap = [
            'blue' => '#3b82f6', 'emerald' => '#10b981', 'amber' => '#f59e0b', 
            'rose' => '#e11d48', 'violet' => '#8b5cf6', 'sky' => '#0ea5e9',
            'indigo' => '#6366f1', 'slate' => '#475569'
        ];

        if (!$hex || !str_starts_with($hex, '#')) {
            $hex = $legacyMap[$hex ?? 'slate'] ?? '#475569';
        }

        return [
            // Return raw inline CSS for custom HTML elements
            'badge_style' => "background-color: {$hex}1A; color: {$hex}; box-shadow: inset 0 0 0 1px {$hex}33;",
            'dot_style' => "background-color: {$hex};",
            'bg_style' => "background-color: {$hex}1A; color: {$hex};",
            'button_style' => "background-color: {$hex};",
        ];
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function transitionsFrom(): HasMany
    {
        return $this->hasMany(ComplaintStatusTransition::class, 'from_complaint_status_id');
    }

    public function transitionsTo(): HasMany
    {
        return $this->hasMany(ComplaintStatusTransition::class, 'to_complaint_status_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
