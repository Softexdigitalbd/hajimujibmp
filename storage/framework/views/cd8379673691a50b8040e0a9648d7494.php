<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <?php echo $__env->make('partials.vite-assets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <style>
            .font-app { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }

            .guest-enter { animation: guestEnter 0.5s ease-out; }
            @keyframes guestEnter {
                from { opacity: 0; transform: translateY(12px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="font-app text-slate-900 antialiased">
        <div class="min-h-screen flex">
            
            <aside class="hidden lg:flex lg:w-[42%] xl:w-2/5 relative flex-col justify-between p-10 xl:p-14 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white overflow-hidden">
                
                <div class="pointer-events-none absolute -top-20 -left-20 h-80 w-80 rounded-full bg-emerald-500/15 blur-[100px]" aria-hidden="true"></div>
                <div class="pointer-events-none absolute bottom-0 right-0 h-64 w-64 rounded-full bg-sky-500/10 blur-[80px]" aria-hidden="true"></div>
                
                <div class="pointer-events-none absolute inset-0 opacity-[0.03]" aria-hidden="true"
                     style="background-image: radial-gradient(rgba(255,255,255,.8) 1px,transparent 1px); background-size: 24px 24px;"></div>

                <div class="relative z-10">
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-3 text-white/95 hover:text-white transition group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400/90 to-emerald-600 ring-1 ring-white/10 shadow-lg shadow-emerald-500/20 transition-transform duration-300 group-hover:scale-105">
                            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-5 w-auto fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-auto fill-current text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                        </span>
                        <span class="text-lg font-bold tracking-tight"><?php echo e(config('app.name')); ?></span>
                    </a>
                </div>
                <div class="relative z-10 space-y-5 max-w-md">
                    <h1 class="text-3xl xl:text-[2.1rem] font-extrabold tracking-tight leading-tight">
                        <?php echo e(__('Your account,')); ?>

                        <span class="bg-gradient-to-r from-emerald-300 to-teal-300 bg-clip-text text-transparent"><?php echo e(__('secured and simple.')); ?></span>
                    </h1>
                    <p class="text-slate-400 text-base leading-relaxed">
                        <?php echo e(__('Sign in to update your profile and stay connected with the site.')); ?>

                    </p>
                </div>
                <p class="relative z-10 text-slate-600 text-sm">
                    © <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>

                </p>
            </aside>

            
            <div class="flex-1 flex flex-col justify-center min-h-screen px-4 py-10 sm:px-8 lg:px-12 xl:px-16 bg-gradient-to-br from-slate-50 via-white to-slate-100/80">
                <div class="lg:hidden mb-8 text-center">
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex flex-col items-center gap-2.5 text-slate-800 hover:text-slate-950 transition">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white shadow-lg shadow-emerald-500/20">
                            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'h-6 w-auto fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-auto fill-current text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                        </span>
                        <span class="text-sm font-bold tracking-tight"><?php echo e(config('app.name')); ?></span>
                    </a>
                </div>

                <div class="w-full max-w-md mx-auto guest-enter">
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 ring-1 ring-slate-200/60 p-8 sm:p-9">
                        <?php echo e($slot); ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/layouts/guest.blade.php ENDPATH**/ ?>