<?php $__env->startSection('title', __('Edit User')); ?>
<?php $__env->startSection('heading', __('Edit User')); ?>
<?php $__env->startSection('subheading', __('Update user details and role assignment.')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4 flex items-center gap-3">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                <?php echo e($user->is_admin ? 'bg-gradient-to-br from-indigo-500 to-violet-600 text-white' : 'bg-slate-100 text-slate-500'); ?>

                text-xs font-bold uppercase">
                <?php echo e(mb_substr($user->name, 0, 1)); ?>

            </span>
            <div>
                <h2 class="text-sm font-bold text-slate-800"><?php echo e($user->name); ?></h2>
                <p class="text-xs text-slate-400"><?php echo e($user->email); ?></p>
            </div>
            <?php if($user->is_admin): ?>
                <span class="ml-auto inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-0.5 text-[11px] font-bold text-indigo-700 ring-1 ring-indigo-200/60">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    Super Admin
                </span>
            <?php endif; ?>
        </div>

        <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="p-6 space-y-5">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5"><?php echo e(__('Full Name')); ?></label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5"><?php echo e(__('Email Address')); ?></label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                        <?php echo e(__('New Password')); ?>

                        <span class="font-normal text-slate-400 normal-case">(<?php echo e(__('leave blank to keep')); ?>)</span>
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="••••••••">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5"><?php echo e(__('Confirm Password')); ?></label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        placeholder="••••••••">
                </div>
            </div>

            
            <?php if(!$user->is_admin): ?>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2"><?php echo e(__('Assigned Role')); ?></label>
                <?php if($roles->isEmpty()): ?>
                    <p class="text-sm text-slate-400 italic"><?php echo e(__('No roles created yet.')); ?></p>
                <?php else: ?>
                <div class="space-y-2">
                    
                    <label for="role_none"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-slate-300 has-[:checked]:border-slate-400 has-[:checked]:bg-slate-50">
                        <input type="radio" id="role_none" name="role_id" value=""
                            class="h-4 w-4 border-slate-300 text-slate-600 focus:ring-slate-400"
                            <?php echo e(old('role_id', $user->role_id) === null ? 'checked' : ''); ?>>
                        <div>
                            <p class="text-sm font-semibold text-slate-600"><?php echo e(__('No Role')); ?></p>
                            <p class="text-xs text-slate-400"><?php echo e(__('User can log in but has no permissions.')); ?></p>
                        </div>
                    </label>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label for="role_<?php echo e($role->id); ?>"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50">
                        <input type="radio" id="role_<?php echo e($role->id); ?>" name="role_id" value="<?php echo e($role->id); ?>"
                            class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            <?php echo e(old('role_id', $user->role_id) == $role->id ? 'checked' : ''); ?>>
                        <div>
                            <p class="text-sm font-semibold text-slate-700"><?php echo e($role->label); ?></p>
                            <?php if($role->description): ?>
                                <p class="text-xs text-slate-400 mt-0.5"><?php echo e($role->description); ?></p>
                            <?php endif; ?>
                        </div>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="rounded-xl bg-amber-50 border border-amber-200/60 px-4 py-3 text-sm text-amber-800">
                <p class="font-semibold"><?php echo e(__('Super Admin Account')); ?></p>
                <p class="text-xs mt-0.5"><?php echo e(__('This user has unrestricted access to all features. Role assignment is not applicable.')); ?></p>
            </div>
            <?php endif; ?>

            
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <?php echo e(__('Save Changes')); ?>

                </button>
                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    <?php echo e(__('Cancel')); ?>

                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/users/edit.blade.php ENDPATH**/ ?>