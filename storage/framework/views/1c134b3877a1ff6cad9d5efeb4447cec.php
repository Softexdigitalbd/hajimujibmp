<?php $__env->startSection('title', __('Edit status')); ?>
<?php $__env->startSection('heading', __('Edit status')); ?>
<?php $__env->startSection('subheading', __('Updating the system name may break seeders or integrations that reference it by slug.')); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.settings.statuses.update', $status)); ?>" class="max-w-2xl rounded-2xl bg-white border border-slate-200 p-6 lg:p-8 shadow-sm space-y-5">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Name (system)')); ?></label>
            <input type="text" name="name" value="<?php echo e(old('name', $status->name)); ?>" pattern="[a-z0-9_]+" class="w-full rounded-xl border border-slate-200 bg-white py-3 px-4 font-mono text-sm focus:border-emerald-500 focus:ring-emerald-500/20" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Display label')); ?></label>
            <input type="text" name="alias_name" value="<?php echo e(old('alias_name', $status->alias_name)); ?>" class="w-full rounded-xl border border-slate-200 bg-white py-3 px-4 text-sm focus:border-emerald-500 focus:ring-emerald-500/20" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('State')); ?></label>
            <select name="state" class="w-full rounded-xl border border-slate-200 bg-white py-3 px-4 text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                <option value="<?php echo e(\App\Models\ComplaintStatus::STATE_STARTED); ?>" <?php if(old('state', $status->state) === \App\Models\ComplaintStatus::STATE_STARTED): echo 'selected'; endif; ?>><?php echo e(__('Started')); ?></option>
                <option value="<?php echo e(\App\Models\ComplaintStatus::STATE_PROCESSING); ?>" <?php if(old('state', $status->state) === \App\Models\ComplaintStatus::STATE_PROCESSING): echo 'selected'; endif; ?>><?php echo e(__('Processing')); ?></option>
                <option value="<?php echo e(\App\Models\ComplaintStatus::STATE_RESOLUTION); ?>" <?php if(old('state', $status->state) === \App\Models\ComplaintStatus::STATE_RESOLUTION): echo 'selected'; endif; ?>><?php echo e(__('Resolution')); ?></option>
            </select>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Badge Color')); ?></label>
                <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-white max-w-[200px]">
                    <input type="color" name="color" value="<?php echo e(old('color', str_starts_with($status->color ?? '', '#') ? $status->color : '#475569')); ?>" class="w-12 h-12 p-0 border-0 bg-transparent block cursor-pointer">
                    <span class="text-sm font-mono text-slate-500 pl-3">Color picker</span>
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Sort order')); ?></label>
                <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $status->sort_order)); ?>" min="0" class="w-full rounded-xl border border-slate-200 bg-white py-3 px-4 text-sm">
            </div>
        </div>
        <input type="hidden" name="is_active" value="0">
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="is_active" value="1" <?php if(old('is_active', $status->is_active)): echo 'checked'; endif; ?> class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            <?php echo e(__('Active')); ?>

        </label>
        <button type="submit" class="rounded-xl bg-slate-900 text-white px-6 py-3 text-sm font-semibold hover:bg-slate-800 shadow-lg shadow-slate-900/10 transition"><?php echo e(__('Save')); ?></button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/settings/statuses/edit.blade.php ENDPATH**/ ?>