<?php $__env->startSection('title', config('app.name') . ' — ' . __('Home')); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-16">

        
        <div class="flex flex-col items-center mb-10">
            <img src="<?php echo e(asset('img/person.webp')); ?>" alt="আলহাজ্ব মুজিবুর রহমান চৌধুরী"
                class="w-full h-auto shadow-lg rounded-lg">
        </div>

        
        <div class="max-w-6xl mx-auto space-y-10">

            
            <div class="rounded-2xl border border-[#1b4d3e]/15 bg-[#1b4d3e]/[0.06] px-8 py-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-8">
                    <div class="space-y-3">
                        <div>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-[#1b4d3e] leading-snug">
                                We are here for you
                            </h1>
                            <p class="mt-1 text-lg font-bold text-[#1b4d3e] noto-bn" lang="bn">আমরা আছি আপনার পাশে</p>
                        </div>

                        <div class="text-base font-medium text-slate-600 leading-relaxed space-y-1">
                            <p>Your feedback helps us improve local services. If you have a complaint, click the button to submit it.</p>
                            <p class="noto-bn" lang="bn">আপনার মতামত আমাদের স্থানীয় সেবা উন্নত করতে সাহায্য করে। কোনো অভিযোগ থাকলে নিচের বোতামে ক্লিক করে জমা দিন।</p>
                        </div>
                    </div>

                    <div class="shrink-0">
                        <a href="<?php echo e(route('complaint.create')); ?>"
                            class="inline-flex items-center justify-center rounded-lg bg-[#2d6a4f] px-6 py-3 text-sm font-bold text-white transition-colors hover:bg-[#1b4d3e] whitespace-nowrap">
                            Submit Complaint <span class="noto-bn ml-1 font-semibold" lang="bn">/ অভিযোগ জানান</span>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <?php
                    $features = [
                        [
                            'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                            'title' => 'গোপনীয়তা',
                            'desc' => 'সাধারণ জনগণের জন্য একটি নিরাপদ, গোপনীয় ও নির্ভরযোগ্য অভিযোগ জানানোর প্ল্যাটফর্ম।'
                        ],
                        ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'সচেতনতা', 'desc' => 'দুর্নীতি, মাদক, সন্ত্রাসসহ সকল ধরনের অনিয়মের বিরুদ্ধে সচেতনতা বৃদ্ধি ও প্রতিরোধ গড়ে তোলা।'],
                        ['icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z', 'title' => 'সুশাসন', 'desc' => 'নির্ভয়ে তথ্য প্রদান করে একটি ন্যায়ভিত্তিক, সুশাসিত ও নিরাপদ সমাজ প্রতিষ্ঠায় সহায়তা করা।'],
                    ];
                ?>
                <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-gradient-to-br from-[#1b4d3e]/10 to-[#2f6b55]/10 p-6 shadow-sm transition-all duration-300 hover:shadow-lg hover:shadow-[#1b4d3e]/5 hover:border-[#a2ccbd] hover:-translate-y-0.5 text-center">
                        <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-[#edf4f1] opacity-0 blur-2xl transition-opacity duration-500 group-hover:opacity-100"
                            aria-hidden="true"></div>
                        <div class="relative flex flex-col items-center">
                            <span
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#edf4f1] to-[#d0e6de] text-[#1b4d3e] ring-1 ring-[#1b4d3e]/10 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($feat['icon']); ?>" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-lg font-extrabold text-[#1b4d3e] noto-bn" lang="bn"><?php echo e($feat['title']); ?></h3>
                            <p class="mt-2 text-base font-medium text-slate-500 leading-relaxed noto-bn" lang="bn">
                                <?php echo e($feat['desc']); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/public/home.blade.php ENDPATH**/ ?>