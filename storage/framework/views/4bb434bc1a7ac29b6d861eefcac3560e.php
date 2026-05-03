<?php $__env->startSection('title', __('System Trash')); ?>
<?php $__env->startSection('heading', __('System Trash')); ?>
<?php $__env->startSection('subheading', __('Recover previously deleted statuses and questions or view discovery records.')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <a href="<?php echo e(route('admin.settings.statuses.index')); ?>"
        class="inline-flex items-center gap-2 rounded-xl bg-white border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        <?php echo e(__('Back to settings')); ?>

    </a>
</div>

<div class="space-y-12">
    
    <div>
        <div class="mb-5 flex items-center gap-3">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-widest"><?php echo e(__('Trashed Statuses')); ?>

            </h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr
                        class="bg-slate-50/90 border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4"><?php echo e(__('Label')); ?></th>
                        <th class="px-6 py-4"><?php echo e(__('State')); ?></th>
                        <th class="px-6 py-4"><?php echo e(__('Deleted At')); ?></th>
                        <th class="px-6 py-4 text-right"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/30 transition text-slate-700">
                        <td class="px-6 py-4 font-medium">
                            <?php $sc = $st->colorClasses(); ?>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset"
                                style="<?php echo e($sc['badge_style']); ?>">
                                <span class="h-1.5 w-1.5 rounded-full" style="<?php echo e($sc['dot_style']); ?>"></span>
                                <?php echo e($st->alias_name); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-200/50"><?php echo e($st->state); ?></span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                            <?php echo e($st->deleted_at->format('M j, Y h:i A')); ?>

                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="<?php echo e(route('admin.settings.statuses.restore', $st->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit"
                                    class="inline-flex h-8 items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 text-xs font-bold text-indigo-700 shadow-sm transition hover:bg-indigo-100 hover:border-indigo-300">
                                    <svg class="h-3 w-3 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    <?php echo e(__('Restore')); ?>

                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center">
                            <p class="text-xs font-bold text-slate-400"><?php echo e(__('No trashed statuses found')); ?></p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div>
        <div class="mb-5 flex items-center gap-3">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600 ring-1 ring-sky-500/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
            </span>
            <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-widest"><?php echo e(__('Trashed Questions')); ?></h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr
                        class="bg-slate-50/90 border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4"><?php echo e(__('Question Prompt')); ?></th>
                        <th class="px-6 py-4"><?php echo e(__('Type')); ?></th>
                        <th class="px-6 py-4"><?php echo e(__('Deleted At')); ?></th>
                        <th class="px-6 py-4 text-right"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/30 transition text-slate-700">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 line-clamp-1"><?php echo e($q->prompt); ?></p>
                            <?php if($q->prompt_bn): ?>
                            <p class="text-[11px] font-medium text-slate-400 mt-0.5 noto-bn"><?php echo e($q->prompt_bn); ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded-full px-2 py-0.5 text-[11px] font-bold bg-slate-100 text-slate-500 ring-1 ring-slate-200/50 uppercase tracking-tighter"><?php echo e($q->type); ?></span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                            <?php echo e($q->deleted_at->format('M j, Y h:i A')); ?>

                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="<?php echo e(route('admin.settings.questions.restore', $q->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit"
                                    class="inline-flex h-8 items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 text-xs font-bold text-indigo-700 shadow-sm transition hover:bg-indigo-100 hover:border-indigo-300">
                                    <svg class="h-3 w-3 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    <?php echo e(__('Restore')); ?>

                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center">
                            <p class="text-xs font-bold text-slate-400"><?php echo e(__('No trashed questions found')); ?></p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/settings/statuses/trash.blade.php ENDPATH**/ ?>