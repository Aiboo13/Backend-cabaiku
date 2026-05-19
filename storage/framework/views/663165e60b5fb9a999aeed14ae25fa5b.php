
<?php $__env->startSection('title', $artikel->judul); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/tips-detail.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
    <a href="<?php echo e(route('tips')); ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <span class="badge badge-primary"><?php echo e($artikel->kategori); ?></span>
</div>
<img src="<?php echo e($artikel->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=800'); ?>" alt="<?php echo e($artikel->judul); ?>" class="art-hero">
<div class="art-meta">
    <div class="art-meta-item"><i class="fa-solid fa-tag"></i> <?php echo e($artikel->kategori); ?></div>
    <div class="art-meta-item"><i class="fa-regular fa-clock"></i> <?php echo e($artikel->waktu_baca); ?> menit baca</div>
    <div class="art-meta-item"><i class="fa-regular fa-user"></i> <?php echo e($artikel->penulis); ?></div>
    <div class="art-meta-item"><i class="fa-regular fa-calendar"></i> <?php echo e($artikel->formatted_date); ?></div>
</div>
<h1 class="art-title"><?php echo e($artikel->judul); ?></h1>
<?php if($artikel->ringkasan): ?><div class="art-summary"><?php echo e($artikel->ringkasan); ?></div><?php endif; ?>
<div class="art-content"><?php echo $artikel->konten; ?></div>
<?php if($related->isNotEmpty()): ?>
<div class="rel-sec">
    <div class="rel-title">📌 Artikel Terkait</div>
    <div class="rel-grid">
        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('tips.show',$r->id)); ?>" class="rel-card">
            <img src="<?php echo e($r->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=400'); ?>" alt="<?php echo e($r->judul); ?>" class="rel-img">
            <div class="rel-body"><div class="rel-kat"><?php echo e($r->kategori); ?></div><div class="rel-judul"><?php echo e($r->judul); ?></div></div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/pages/tips-detail.blade.php ENDPATH**/ ?>