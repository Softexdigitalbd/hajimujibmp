<?php $__env->startSection('title', __('User Management')); ?>
<?php $__env->startSection('heading', __('User Management')); ?>
<?php $__env->startSection('subheading', __('Create and manage admin panel users and assign their role.')); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <span class="font-semibold text-slate-800"><?php echo e($users->total()); ?></span> <?php echo e(__('users total')); ?>

        </div>
        <?php if(auth()->user()->hasPermission('users.create')): ?>
        <a href="<?php echo e(route('admin.users.create')); ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <?php echo e(__('Add User')); ?>

        </a>
        <?php endif; ?>
    </div>

    <?php if(session('error')): ?>
        <div class="flex items-center gap-3 rounded-2xl bg-red-50 border border-red-200/60 text-red-800 px-5 py-4 text-sm font-medium">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/80">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500"><?php echo e(__('User')); ?></th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500"><?php echo e(__('Role')); ?></th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500"><?php echo e(__('Type')); ?></th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500"><?php echo e(__('Joined')); ?></th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="group transition-colors hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl
                                <?php echo e($user->is_admin ? 'bg-gradient-to-br from-indigo-500 to-violet-600' : 'bg-slate-100'); ?>

                                text-xs font-bold uppercase
                                <?php echo e($user->is_admin ? 'text-white' : 'text-slate-500'); ?>">
                                <?php echo e(mb_substr($user->name, 0, 1)); ?>

                            </span>
                            <div>
                                <p class="font-semibold text-slate-800"><?php echo e($user->name); ?></p>
                                <p class="text-xs text-slate-400"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($user->is_admin): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2.5 py-0.5 text-[11px] font-bold text-indigo-700 ring-1 ring-indigo-200/60">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                Super Admin
                            </span>
                        <?php elseif($user->role): ?>
                            <span class="inline-flex items-center rounded-full bg-violet-50 px-2.5 py-0.5 text-[11px] font-semibold text-violet-700 ring-1 ring-violet-200/60">
                                <?php echo e($user->role->label); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-xs text-slate-400 italic"><?php echo e(__('No role')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($user->is_admin): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-bold text-amber-700 ring-1 ring-amber-200/60">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Admin
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 px-2.5 py-0.5 text-[11px] font-bold text-sky-700 ring-1 ring-sky-200/60">
                                <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                                Staff
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-400">
                        <?php echo e($user->created_at->format('M j, Y')); ?>

                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <?php if(auth()->user()->hasPermission('users.edit')): ?>
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>"
                               class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-indigo-100 hover:text-indigo-700">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                <?php echo e(__('Edit')); ?>

                            </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->hasPermission('users.delete') && !$user->is_admin && $user->id !== auth()->id()): ?>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                                  onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this user?')); ?>')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    <?php echo e(__('Delete')); ?>

                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-600"><?php echo e(__('No users found')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
    <div><?php echo e($users->links()); ?></div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/users/index.blade.php ENDPATH**/ ?>