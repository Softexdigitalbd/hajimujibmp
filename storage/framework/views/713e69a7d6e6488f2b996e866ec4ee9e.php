<?php $__env->startSection('title', __('Edit question')); ?>
<?php $__env->startSection('heading', __('Edit question')); ?>
<?php $__env->startSection('subheading', __('Updating labels changes what visitors see; stored answers keep their previous text.')); ?>

<?php $__env->startSection('content'); ?>
    <div class="relative -mx-6 lg:-mx-8 -mt-6 lg:-mt-8 mb-0 min-h-[calc(100vh-6rem)] overflow-hidden rounded-2xl border border-slate-200/60 bg-gradient-to-br from-slate-50 via-white to-teal-50/35">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_45%_at_100%_0%,rgba(20,184,166,0.1),transparent)]"></div>
        <div class="relative max-w-3xl mx-auto px-6 lg:px-10 py-10 lg:py-14">
            <div class="flex items-start justify-between gap-4 mb-10">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-teal-700/80"><?php echo e(__('Editing')); ?> #<?php echo e($question->id); ?></p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900 tracking-tight line-clamp-2"><?php echo e($question->prompt); ?></h2>
                </div>
                <a href="<?php echo e(route('admin.settings.questions.index')); ?>" class="shrink-0 text-sm font-semibold text-slate-500 hover:text-slate-800 transition"><?php echo e(__('Close')); ?></a>
            </div>

            <form method="POST" action="<?php echo e(route('admin.settings.questions.update', $question)); ?>" 
                x-data="{ 
                    type: '<?php echo e(old('type', $question->type)); ?>',
                    options: <?php echo \Illuminate\Support\Js::from(old('options', $question->options->pluck('label')->all() ?: ['']))->toHtml() ?>
                }"
                class="rounded-2xl bg-white/90 backdrop-blur-sm border border-slate-200 shadow-xl shadow-slate-200/30 p-6 sm:p-8 space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Label (English)')); ?></label>
                    <input type="text" name="prompt" value="<?php echo e(old('prompt', $question->prompt)); ?>" class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 px-4 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-sm transition-all" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Extra Bangla line (optional)')); ?></label>
                    <input type="text" name="prompt_bn" value="<?php echo e(old('prompt_bn', $question->prompt_bn)); ?>" lang="bn" class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 px-4 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-sm transition-all noto-bn">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Answer type')); ?></label>
                    <div class="relative">
                        <select name="type" x-model="type" class="w-full appearance-none rounded-xl border-2 border-slate-200 bg-white py-3 pl-4 pr-10 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-sm transition-all">
                            <option value="text"><?php echo e(__('Short text')); ?></option>
                            <option value="textarea"><?php echo e(__('Long text')); ?></option>
                            <option value="email"><?php echo e(__('Email')); ?></option>
                            <option value="phone"><?php echo e(__('Phone')); ?></option>
                            <option value="selection"><?php echo e(__('Choice list')); ?></option>
                            <option value="boolean"><?php echo e(__('Yes / No (checkbox)')); ?></option>
                            <option value="file"><?php echo e(__('File upload')); ?></option>
                        </select>
                        <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </div>
                    </div>
                </div>

                <div x-show="type === 'selection'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-4 p-5 rounded-2xl bg-emerald-50/40 border border-emerald-100/80">
                    
                    <div class="flex items-center justify-between gap-4">
                        <label class="block text-[11px] font-extrabold text-emerald-800 uppercase tracking-widest"><?php echo e(__('List Options')); ?></label>
                        <button type="button" @click="options.push('')" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-800 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            <?php echo e(__('Add Option')); ?>

                        </button>
                    </div>

                    <div class="space-y-2.5">
                        <template x-for="(opt, index) in options" :key="index">
                            <div class="flex items-center gap-2 group">
                                <span class="text-[10px] font-bold text-emerald-300 w-4" x-text="index + 1"></span>
                                <input type="text" name="options[]" x-model="options[index]" class="flex-1 rounded-xl border-2 border-slate-200 bg-white py-2.5 px-4 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-sm transition-all" :placeholder="'<?php echo e(__('Option')); ?> ' + (index + 1)">
                                <button type="button" @click="options.splice(index, 1)" class="p-2 text-slate-300 hover:text-rose-500 transition opacity-0 group-hover:opacity-100" x-show="options.length > 1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <label class="flex items-center gap-4 text-sm font-bold text-slate-700 pt-3 cursor-pointer group border-t border-emerald-100/40">
                        <div class="relative flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border-2 border-slate-300 bg-white transition-all group-hover:border-emerald-400 group-has-[:checked]:border-emerald-500 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:shadow-lg group-has-[:checked]:shadow-emerald-500/20">
                            <input type="checkbox" name="allow_multiple" value="1" <?php if(old('allow_multiple', $question->allow_multiple)): echo 'checked'; endif; ?> class="peer absolute h-full w-full opacity-0 cursor-pointer">
                            <svg class="h-3.5 w-3.5 scale-0 font-black text-white transition-transform peer-checked:scale-100" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </div>
                        <span class="group-hover:text-slate-900 transition-colors"><?php echo e(__('Allow residents to select multiple items')); ?></span>
                    </label>
                </div>

                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2"><?php echo e(__('Sort order')); ?></label>
                        <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $question->sort_order)); ?>" min="0" class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 px-4 text-sm font-semibold text-slate-800 focus:border-emerald-500 focus:ring-emerald-500/20 shadow-sm transition-all">
                    </div>
                    <div class="flex flex-col justify-end gap-5 pb-1">
                        <label class="flex items-center gap-4 text-sm font-bold text-slate-700 cursor-pointer group">
                            <div class="relative flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border-2 border-slate-300 bg-white transition-all group-hover:border-emerald-400 group-has-[:checked]:border-emerald-500 group-has-[:checked]:bg-emerald-500 group-has-[:checked]:shadow-lg group-has-[:checked]:shadow-emerald-500/20">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" <?php if(old('is_active', $question->is_active)): echo 'checked'; endif; ?> class="peer absolute h-full w-full opacity-0 cursor-pointer">
                                <svg class="h-3.5 w-3.5 scale-0 font-black text-white transition-transform peer-checked:scale-100" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="group-hover:text-slate-900 transition-colors"><?php echo e(__('Active on public form')); ?></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter"><?php echo e(__('Controls visibility')); ?></span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="<?php echo e(route('admin.settings.questions.index')); ?>" class="inline-flex items-center rounded-xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all active:scale-95">
                        <?php echo e(__('Discard')); ?>

                    </a>
                    <button type="submit" class="rounded-xl bg-slate-900 text-white px-8 py-3 text-sm font-bold shadow-lg shadow-slate-900/15 transition-all hover:bg-black hover:-translate-y-0.5 active:translate-y-0">
                        <?php echo e(__('Update Question')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/admin/settings/questions/edit.blade.php ENDPATH**/ ?>