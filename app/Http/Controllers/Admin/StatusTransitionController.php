<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintStatus;
use App\Models\ComplaintStatusTransition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatusTransitionController extends Controller
{
    public function index(): View
    {
        $setting = \App\Models\AppSetting::query()->first();
        $statuses = ComplaintStatus::query()->with('transitionsFrom.toStatus')->orderBy('sort_order')->get();

        $allowed = [];
        foreach (ComplaintStatusTransition::query()->get() as $t) {
            $allowed[$t->from_complaint_status_id][$t->to_complaint_status_id] = true;
        }

        $transitions = ComplaintStatusTransition::query()
            ->with(['fromStatus', 'toStatus'])
            ->orderBy('from_complaint_status_id')
            ->get();

        $mermaidGraph = $this->mermaidFlowchart($statuses, $transitions, optional($setting)->new_complaint_status_id);

        return view('admin.settings.transitions.index', compact('statuses', 'mermaidGraph', 'allowed', 'setting'));
    }

    public function sync(Request $request): RedirectResponse
    {
        $statuses = ComplaintStatus::query()->orderBy('sort_order')->get();
        $ids = $statuses->pluck('id')->all();

        $input = $request->input('allow', []);
        if (! is_array($input)) {
            $input = [];
        }

        DB::transaction(function () use ($input, $ids) {
            ComplaintStatusTransition::query()->delete();

            foreach ($input as $fromKey => $tos) {
                $fromId = (int) $fromKey;
                if (! in_array($fromId, $ids, true)) {
                    continue;
                }
                foreach ((array) $tos as $toId) {
                    $toId = (int) $toId;
                    if ($fromId === $toId || ! in_array($toId, $ids, true)) {
                        continue;
                    }
                    ComplaintStatusTransition::query()->create([
                        'from_complaint_status_id' => $fromId,
                        'to_complaint_status_id' => $toId,
                    ]);
                }
            }
        });

        return back()->with('success', __('Workflow updated.'));
    }

    private function mermaidFlowchart($statuses, $transitions, ?int $startId): string
    {
        $lines = ['flowchart LR'];

        $orderedStates = ['Started', 'Processing', 'Resolution'];
        $grouped = $statuses->groupBy('state');

        foreach ($orderedStates as $stateName) {
            if (!$grouped->has($stateName)) continue;
            $group = $grouped->get($stateName);
            $clusterId = 'G_'.preg_replace('/\W+/', '_', (string) $stateName);
            $title = $this->mermaidEscape((string) $stateName);
            $lines[] = "  subgraph {$clusterId}[\"{$title}\"]";
            foreach ($group as $s) {
                $label = $this->mermaidEscape($s->alias_name);
                $isStart = $s->id === $startId;
                $shape = $isStart ? "([{$label}])" : "[{$label}]";
                $lines[] = "    st{$s->id}{$shape}";
            }
            $lines[] = '  end';
        }

        /* Individual transitions are now hidden for a cleaner high-level overview */
        /*
        foreach ($transitions as $t) {
            $lines[] = "  st{$t->from_complaint_status_id} --> st{$t->to_complaint_status_id}";
        }
        */

        $classMap = [
            'Started' => 'stStarted',
            'Processing' => 'stProcessing',
            'Resolution' => 'stResolution',
        ];
        
        foreach ($orderedStates as $stateName) {
            if (!$grouped->has($stateName)) continue;
            $group = $grouped->get($stateName);
            $cls = $classMap[(string) $stateName] ?? 'stDefault';
            $nodes = [];
            foreach ($group as $s) {
                if ($s->id !== $startId) {
                    $nodes[] = 'st'.$s->id;
                }
            }
            if (!empty($nodes)) {
                $lines[] = "  class ".implode(',', $nodes)." {$cls}";
            }
        }

        if ($startId) {
            $lines[] = "  class st{$startId} stEntry";
        }

        // Enforce subgraph order by adding explicit edges between groups for a clear path
        $lastGroup = null;
        foreach (['Started', 'Processing', 'Resolution'] as $state) {
            if ($grouped->has($state) && $grouped->get($state)->isNotEmpty()) {
                $clusterId = 'G_'.preg_replace('/\W+/', '_', (string) $state);
                if ($lastGroup) {
                    $lines[] = "  {$lastGroup} --> {$clusterId}";
                }
                $lastGroup = $clusterId;
            }
        }

        $lines[] = '  classDef stEntry fill:#f0f9ff,stroke:#0ea5e9,stroke-width:4px,color:#0c4a6e';
        $lines[] = '  classDef stStarted fill:#f8fafc,stroke:#94a3b8,stroke-width:1px,color:#475569';
        $lines[] = '  classDef stProcessing fill:#fff7ed,stroke:#fb923c,stroke-width:1.5px,color:#9a3412';
        $lines[] = '  classDef stResolution fill:#f0fdf4,stroke:#22c55e,stroke-width:1.5px,color:#14532d';
        $lines[] = '  classDef stDefault fill:#f8fafc,stroke:#e2e8f0,color:#64748b';

        return implode("\n", $lines);
    }

    private function mermaidEscape(string $text): string
    {
        $text = strip_tags($text);

        return str_replace(['"', "\n", "\r", '(', ')'], ["'", ' ', ' ', ' ', ' '], $text);
    }
}
