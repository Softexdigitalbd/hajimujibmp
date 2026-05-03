<?php $__env->startSection('title', __('Thank you').' — '.config('app.name')); ?>

<?php $__env->startPush('head'); ?>
<meta http-equiv="refresh" content="5;url=<?php echo e(route('home')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto text-center space-y-6">
    <div
        class="relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-xl shadow-slate-200/40 p-8 sm:p-10">
        
        <div class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 h-40 w-40 rounded-full bg-teal-500/10 blur-[60px]"
            aria-hidden="true"></div>

        <div class="relative space-y-6">
            
            <span
                class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 text-white shadow-xl shadow-teal-500/25 mx-auto">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </span>

            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    <?php echo e(__('Thank you')); ?>

                </h1>
                <p class="text-xl font-semibold text-teal-600 noto-bn" lang="bn">ধন্যবাদ</p>
            </div>

            <div class="space-y-4">
                <p class="text-sm font-bold text-teal-600">
                    <?php echo e(__('Your complaint (Reference: :ref) has been submitted successfully.', ['ref' => $complaint->public_reference])); ?>

                </p>
                <p class="text-sm font-bold text-teal-600 noto-bn" lang="bn">
                    আপনার অভিযোগটি সফলভাবে জমা দেওয়া হয়েছে। রেফারেন্স: <?php echo e($complaint->public_reference); ?>

                </p>
            </div>

            <div class="rounded-lg bg-slate-50 border border-slate-200/60 px-5 py-4 mt-6">
                <p class="text-xs text-slate-500 mb-2 uppercase tracking-wider font-bold"><?php echo e(__('Unique Tracking Reference')); ?> (রেফারেন্স নং):</p>
                <span
                    class="inline-flex items-center gap-3 font-mono text-2xl font-black text-slate-900 tracking-tighter bg-white px-5 py-2.5 rounded-lg border-2 border-teal-500 shadow-xl shadow-teal-500/10">
                    <?php echo e($complaint->public_reference); ?>

                </span>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/public/complaint-thanks.blade.php ENDPATH**/ ?>