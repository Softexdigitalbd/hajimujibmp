<?php
    $viteAvailable = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
?>
<?php if($viteAvailable): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<?php else: ?>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
<?php endif; ?>
<?php /**PATH /home/storage/517/4794517/user/htdocs/resources/views/partials/vite-assets.blade.php ENDPATH**/ ?>