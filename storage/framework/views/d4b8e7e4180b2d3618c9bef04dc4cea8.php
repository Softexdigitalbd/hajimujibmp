<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|noto-sans-bengali:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo $__env->make('partials.vite-assets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .noto-bn { font-family: 'Noto Sans Bengali', 'Inter', ui-sans-serif, system-ui, sans-serif; }

        /* Entrance animation */
        .public-enter { animation: publicEnter 0.5s ease-out; }
        @keyframes publicEnter {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-[#edf4f1]/30 text-slate-900 min-h-screen flex flex-col">
    
    <header class="sticky top-0 z-40 border-b border-slate-200/60 bg-white/90 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex h-16 items-center justify-between">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2.5 group">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-[#236150] to-[#143c30] text-white shadow-md shadow-[#1b4d3e]/20 transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </span>
                    <span class="text-sm font-bold tracking-tight text-slate-900"><?php echo e(config('app.name')); ?></span>
                </a>
                <nav class="flex items-center gap-1 text-sm font-medium">
                    <a href="<?php echo e(route('home')); ?>" class="rounded-lg px-3.5 py-2 text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900"><?php echo e(__('Home')); ?></a>
                    <a href="<?php echo e(route('complaint.create')); ?>" class="rounded-md bg-[#2d6a4f] px-5 py-2 text-white font-semibold transition-colors hover:bg-[#143c30]"><?php echo e(__('Complaint')); ?></a>

                </nav>
            </div>
        </div>
    </header>

    
    <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 py-10 sm:py-12 flex-1 public-enter">
        <?php if(session('success')): ?>
            <div class="mb-6 flex items-center gap-3 rounded-xl bg-[#edf4f1] border border-[#a2ccbd]/60 text-[#0d2b22] px-5 py-4 text-sm font-medium shadow-sm">
                <svg class="h-5 w-5 text-[#236150] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="border-t border-slate-200/60 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('All rights reserved.')); ?></p>
            <div class="flex items-center gap-4 text-sm text-slate-400">
                <a href="<?php echo e(route('home')); ?>" class="transition hover:text-[#1b4d3e]"><?php echo e(__('Home')); ?></a>
                <span class="text-slate-300">·</span>
                <a href="<?php echo e(route('complaint.create')); ?>" class="transition hover:text-[#1b4d3e]"><?php echo e(__('Submit complaint')); ?></a>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/layouts/public.blade.php ENDPATH**/ ?>