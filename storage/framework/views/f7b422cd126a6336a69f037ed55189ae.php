<?php $__env->startSection('title', __('Edit Role')); ?>
<?php $__env->startSection('heading', __('Edit Role: ').$role->label); ?>
<?php $__env->startSection('subheading', __('Update role name, description, and permission assignments.')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl space-y-6">

    <form method="POST" action="<?php echo e(route('admin.roles.update', $role)); ?>" class="space-y-6">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800"><?php echo e(__('Role Information')); ?></h2>
                <code class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-mono text-slate-500"><?php echo e($role->name); ?></code>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="label" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5"><?php echo e(__('Display Name')); ?></label>
                    <input type="text" id="label" name="label" value="<?php echo e(old('label', $role->label)); ?>" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5"><?php echo e(__('Description')); ?></label>
                    <textarea id="description" name="description" rows="2"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 resize-none"><?php echo e(old('description', $role->description)); ?></textarea>
                </div>
            </div>
        </div>

        
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-800"><?php echo e(__('Permissions')); ?></h2>
                <button type="button" id="selectAll"
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                    <?php echo e(__('Select All')); ?>

                </button>
            </div>
            <div class="p-6 space-y-6">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupPerms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400"><?php echo e($group); ?></span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <?php $__currentLoopData = $groupPerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label for="perm_<?php echo e($perm->id); ?>"
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50">
                            <input type="checkbox" id="perm_<?php echo e($perm->id); ?>" name="permissions[]" value="<?php echo e($perm->id); ?>"
                                class="perm-cb h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                <?php echo e(in_array($perm->id, old('permissions', $rolePermIds)) ? 'checked' : ''); ?>>
                            <div>
                                <p class="text-sm font-medium text-slate-700"><?php echo e($perm->label); ?></p>
                                <code class="text-[10px] text-slate-400 font-mono"><?php echo e($perm->name); ?></code>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-xl hover:-translate-y-0.5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <?php echo e(__('Save Changes')); ?>

            </button>
            <a href="<?php echo e(route('admin.roles.index')); ?>"
                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                <?php echo e(__('Cancel')); ?>

            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const btn = document.getElementById('selectAll');
    const cbs = document.querySelectorAll('.perm-cb');
    let allChecked = cbs.length > 0 && [...cbs].every(cb => cb.checked);
    btn.textContent = allChecked ? '<?php echo e(__("Deselect All")); ?>' : '<?php echo e(__("Select All")); ?>';
    btn.addEventListener('click', () => {
        allChecked = !allChecked;
        cbs.forEach(cb => cb.checked = allChecked);
        btn.textContent = allChecked ? '<?php echo e(__("Deselect All")); ?>' : '<?php echo e(__("Select All")); ?>';
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/roles/edit.blade.php ENDPATH**/ ?>