<?php $__env->startSection('title', __('Complaints')); ?>
<?php $__env->startSection('heading', __('Complaints')); ?>
<?php $__env->startSection('subheading', __('Search, filter and manage submitted complaints.')); ?>

<?php $__env->startSection('content'); ?>


<div x-data="{ showFilter: <?php echo e(request()->anyFilled(['status_id', 'filters']) ? 'true' : 'false'); ?> }" class="mb-6">
    <div class="mb-4 flex justify-end">
        <button @click="showFilter = !showFilter" type="button"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <span x-text="showFilter ? '<?php echo e(__('Hide filters')); ?>' : '<?php echo e(__('Show filters')); ?>'"></span>
            <svg class="h-4 w-4 text-slate-400 transition-transform duration-200"
                :class="showFilter ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
    </div>

    <form x-show="showFilter" x-transition method="GET"
        class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-3 items-end gap-5 p-5">
            <div class="min-w-[170px]">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2"><?php echo e(__('Status')); ?></label>
                <select name="status_id"
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    <option value=""><?php echo e(__('All statuses')); ?></option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($st->id); ?>" <?php if(request('status_id')==$st->id): echo 'selected'; endif; ?>><?php echo e($st->alias_name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <?php $__currentLoopData = $filterQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="min-w-[150px]">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2"><?php echo e($fq->prompt); ?></label>
                <?php if($fq->type === \App\Models\ComplaintQuestion::TYPE_SELECTION): ?>
                <select name="filters[<?php echo e($fq->id); ?>]"
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    <option value=""><?php echo e(__('All')); ?> <?php echo e($fq->prompt); ?></option>
                    <?php $__currentLoopData = $fq->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($opt->label); ?>" <?php if(request("filters.{$fq->id}") == $opt->label): echo 'selected'; endif; ?>><?php echo e($opt->label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php elseif($fq->type === \App\Models\ComplaintQuestion::TYPE_BOOLEAN): ?>
                <select name="filters[<?php echo e($fq->id); ?>]"
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                    <option value=""><?php echo e(__('Any')); ?></option>
                    <option value="1" <?php if(request("filters.{$fq->id}") === '1'): echo 'selected'; endif; ?>><?php echo e(__('Yes')); ?></option>
                    <option value="0" <?php if(request("filters.{$fq->id}") === '0'): echo 'selected'; endif; ?>><?php echo e(__('No')); ?></option>
                </select>
                <?php else: ?>
                <input type="text" name="filters[<?php echo e($fq->id); ?>]" value="<?php echo e(request('filters.'.$fq->id)); ?>"
                    placeholder="<?php echo e($fq->prompt); ?>"
                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="flex items-center justify-end gap-2 md:col-span-3 mt-2 border-t border-slate-100 pt-5">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-slate-800 hover:shadow-md">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    <?php echo e(__('Filter')); ?>

                </button>
                <?php if(request()->anyFilled(['status_id', 'filters'])): ?>
                <a href="<?php echo e(route('admin.complaints.index')); ?>"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-900">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <?php echo e(__('Clear')); ?>

                </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>


<div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">

    
    <div
        class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white px-6 py-3.5">
        <p class="text-xs font-bold text-slate-500">
            <?php echo e($complaints->total()); ?> <?php echo e(Str::plural('complaint', $complaints->total())); ?> found
        </p>
        <?php if(request()->anyFilled(['q', 'status_id', 'filters'])): ?>
        <span
            class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-700 ring-1 ring-amber-200/80">
            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
            <?php echo e(__('Filtered')); ?>

        </span>
        <?php endif; ?>
    </div>

    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 text-left">
                <th class="px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-slate-400"><?php echo e(__('ID')); ?>

                </th>
                <th class="px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-slate-400"><?php echo e(__('Feedback
                    Subject')); ?></th>
                <th class="px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-slate-400"><?php echo e(__('Status')); ?></th>
                <th
                    class="hidden px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-slate-400 sm:table-cell">
                    <?php echo e(__('Submitted')); ?></th>
                <th class="px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-slate-400 text-right"><?php echo e(__('Action')); ?></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="group transition-colors duration-200 hover:bg-emerald-50/30">
                <td class="px-6 py-4">
                    <span class="inline-flex items-center font-mono text-[10.5px] font-bold text-slate-500">
                        <?php echo e($c->public_reference); ?>

                    </span>
                </td>
                <td class="px-6 py-4 align-middle">
                    <?php
                    $subjectAnswer = $c->answers->first(function($a) {
                        $p = mb_strtolower($a->question?->prompt ?? '', 'UTF-8');
                        return str_contains($p, 'subject') || str_contains($p, 'বিষয়');
                    });
                    
                    if ($subjectAnswer) {
                        $decoded = json_decode($subjectAnswer->value, true);
                        $val = is_array($decoded) ? implode(', ', $decoded) : $subjectAnswer->value;
                        $subjectText = str($val)->limit(45);
                    } else {
                        $subjectText = __('No subject available');
                    }
                    ?>
                    <span class="text-sm font-medium text-slate-800">
                        <?php echo e($subjectText); ?>

                    </span>
                </td>
                <td class="px-6 py-4">
                    <?php $sc = $c->status->colorClasses(); ?>
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset"
                        style="<?php echo e($sc['badge_style']); ?>">
                        <span class="h-1.5 w-1.5 rounded-full" style="<?php echo e($sc['dot_style']); ?>"></span>
                        <?php echo e($c->status->alias_name); ?>

                    </span>
                </td>
                <td class="hidden px-6 py-4 text-xs text-slate-500 sm:table-cell">
                    <span class="font-medium text-slate-600"><?php echo e($c->created_at->format('M j, Y')); ?></span>
                    <span class="ml-1 text-slate-400"><?php echo e($c->created_at->format('h:i A')); ?></span>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="<?php echo e(route('admin.complaints.show', $c)); ?>"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-md group-hover:border-slate-300">
                        <?php echo e(__('Open')); ?>

                        <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-0.5"
                            fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <span
                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-slate-700"><?php echo e(__('No complaints found')); ?></p>
                            <p class="mt-1 text-xs text-slate-400"><?php echo e(__('New submissions from the public form will
                                appear here.')); ?></p>
                        </div>
                        <?php if(request()->anyFilled(['q', 'status_id', 'filters'])): ?>
                        <a href="<?php echo e(route('admin.complaints.index')); ?>"
                            class="mt-1 inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:border-slate-300">
                            <?php echo e(__('Clear filters')); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($complaints->hasPages()): ?>
<div class="mt-5">
    <?php echo e($complaints->links()); ?>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/complaints/index.blade.php ENDPATH**/ ?>