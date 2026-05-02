<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\ComplaintStatus;
use App\Models\ComplaintStatusTransition;
use Illuminate\Database\Seeder;

class ComplaintWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        // color maps to ComplaintStatus::colorClasses() key — one of:
        // blue | emerald | amber | rose | violet | sky | indigo | slate
        $defs = [
            ['name' => 'submitted',   'alias_name' => 'Submitted',    'state' => ComplaintStatus::STATE_STARTED,    'color' => '#3b82f6',  'sort_order' => 10], // blue-500
            ['name' => 'invalid',     'alias_name' => 'Invalid',       'state' => ComplaintStatus::STATE_STARTED,    'color' => '#e11d48',  'sort_order' => 20], // rose-600
            ['name' => 'hold',        'alias_name' => 'On Hold',       'state' => ComplaintStatus::STATE_STARTED,    'color' => '#f59e0b',  'sort_order' => 30], // amber-500
            ['name' => 'processing',  'alias_name' => 'In Progress',   'state' => ComplaintStatus::STATE_PROCESSING, 'color' => '#8b5cf6',  'sort_order' => 40], // violet-500
            ['name' => 'resolved',    'alias_name' => 'Resolved',      'state' => ComplaintStatus::STATE_RESOLUTION, 'color' => '#10b981',  'sort_order' => 50], // emerald-500
            ['name' => 'unresolved',  'alias_name' => 'Unresolved',    'state' => ComplaintStatus::STATE_RESOLUTION, 'color' => '#475569',  'sort_order' => 60], // slate-600
            ['name' => 'reopen',      'alias_name' => 'Reopened',      'state' => ComplaintStatus::STATE_PROCESSING, 'color' => '#6366f1',  'sort_order' => 70], // indigo-500
        ];

        foreach ($defs as $def) {
            ComplaintStatus::query()->updateOrCreate(
                ['name' => $def['name']],
                [
                    'alias_name' => $def['alias_name'],
                    'state'      => $def['state'],
                    'color'      => $def['color'],
                    'sort_order' => $def['sort_order'],
                    'is_active'  => true,
                ]
            );
        }

        $id = fn (string $name) => ComplaintStatus::query()->where('name', $name)->value('id');

        $pairs = [
            ['submitted', 'invalid'],
            ['submitted', 'hold'],
            ['submitted', 'processing'],
            ['hold', 'processing'],
            ['hold', 'invalid'],
            ['processing', 'resolved'],
            ['processing', 'unresolved'],
            ['resolved', 'reopen'],
            ['unresolved', 'reopen'],
            ['reopen', 'processing'],
        ];

        foreach ($pairs as [$from, $to]) {
            ComplaintStatusTransition::query()->firstOrCreate(
                [
                    'from_complaint_status_id' => $id($from),
                    'to_complaint_status_id' => $id($to),
                ],
                []
            );
        }

        $setting = AppSetting::query()->first();
        $payload = [
            'new_complaint_status_id' => $id('submitted'),
            'reopen_status_id' => $id('reopen'),
        ];

        if ($setting) {
            $setting->update($payload);
        } else {
            AppSetting::query()->create($payload);
        }
    }
}
