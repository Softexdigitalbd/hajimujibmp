<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // ── All-time totals ───────────────────────────────────────────────────
        $totalComplaints = Complaint::count();

        $statusCounts = ComplaintStatus::select(
                'complaint_statuses.id',
                'complaint_statuses.alias_name',
                'complaint_statuses.state',
                'complaint_statuses.color',
                DB::raw('count(complaints.id) as count')
            )
            ->leftJoin('complaints', 'complaints.complaint_status_id', '=', 'complaint_statuses.id')
            ->groupBy(
                'complaint_statuses.id',
                'complaint_statuses.alias_name',
                'complaint_statuses.state',
                'complaint_statuses.color',
                'complaint_statuses.sort_order'
            )
            ->orderBy('complaint_statuses.sort_order')
            ->get();

        $completedStates = [ComplaintStatus::STATE_RESOLUTION];
        $resolvedCount   = $statusCounts->whereIn('state', $completedStates)->sum('count');
        $activeCount     = $totalComplaints - $resolvedCount;
        $resolutionRate  = $totalComplaints > 0 ? round(($resolvedCount / $totalComplaints) * 100) : 0;

        // ── Today's stats ─────────────────────────────────────────────────────
        $todayTotal    = Complaint::whereDate('created_at', $today)->count();
        $todayResolved = Complaint::whereDate('created_at', $today)
            ->whereHas('status', fn ($q) => $q->whereIn('state', $completedStates))
            ->count();
        $todayPending  = $todayTotal - $todayResolved;

        // Per-status counts for today (for badge display)
        $todayStatusCounts = ComplaintStatus::select(
                'complaint_statuses.id',
                'complaint_statuses.alias_name',
                'complaint_statuses.state',
                'complaint_statuses.color',
                DB::raw('count(complaints.id) as count')
            )
            ->leftJoin('complaints', function ($join) use ($today) {
                $join->on('complaints.complaint_status_id', '=', 'complaint_statuses.id')
                     ->whereDate('complaints.created_at', $today);
            })
            ->groupBy(
                'complaint_statuses.id',
                'complaint_statuses.alias_name',
                'complaint_statuses.state',
                'complaint_statuses.color',
                'complaint_statuses.sort_order'
            )
            ->orderBy('complaint_statuses.sort_order')
            ->get();

        // ── Day-wise complaints for the last 30 days ──────────────────────────
        $days = 30;
        $dailyComplaints = Complaint::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Build a full 30-day range (fill blanks with 0)
        $dailyLabels = [];
        $dailyData   = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = now()->subDays($i)->format('M j');
            $dailyData[]   = $dailyComplaints->has($date)
                ? (int) $dailyComplaints[$date]->total
                : 0;
        }

        // ── Recent complaints ─────────────────────────────────────────────────
        $recentComplaints = Complaint::with('status')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalComplaints',
            'activeCount',
            'resolutionRate',
            'statusCounts',
            'recentComplaints',
            'todayTotal',
            'todayResolved',
            'todayPending',
            'todayStatusCounts',
            'dailyLabels',
            'dailyData'
        ));
    }
}
