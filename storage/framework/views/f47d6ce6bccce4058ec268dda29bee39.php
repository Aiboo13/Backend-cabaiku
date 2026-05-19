
<?php $__env->startSection('title','Tips & Artikel'); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/tips.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1>📖 Tips & Artikel</h1><p>Panduan lengkap merawat dan membudidayakan tanaman cabai</p></div>

<form method="GET" action="<?php echo e(route('tips')); ?>" id="filter-form">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" name="q" class="search-inp" id="search-inp" placeholder="Cari artikel, tips, atau panduan..." value="<?php echo e(request('q')); ?>" oninput="toggleClear(this)">
        <button type="button" class="search-clear <?php echo e(request('q') ? 'show' : ''); ?>" id="clear-btn" onclick="clearSearch()"><i class="fa-solid fa-xmark"></i></button>
        <input type="hidden" name="kategori" value="<?php echo e(request('kategori')); ?>">
    </div>
</form>

<div class="filter-tags">
    <a href="<?php echo e(route('tips', ['q'=>request('q')])); ?>" class="ftag <?php echo e(!request('kategori') ? 'active' : ''); ?>">Semua</a>
    <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('tips', ['q'=>request('q'),'kategori'=>$k])); ?>" class="ftag <?php echo e(request('kategori')==$k ? 'active' : ''); ?>"><?php echo e($k); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if(request('q')): ?><div style="font-size:.83rem;color:var(--text-muted);margin-bottom:16px;">Hasil: <strong style="color:var(--text);">"<?php echo e(request('q')); ?>"</strong> — <strong><?php echo e($artikels->total()); ?></strong> artikel <a href="<?php echo e(route('tips')); ?>" style="color:var(--primary);margin-left:8px;">Hapus filter</a></div><?php endif; ?>

<?php if($artikels->isEmpty()): ?>
<div class="empty"><div class="empty-icon">📭</div><h3 style="font-weight:700;margin-bottom:8px;">Artikel Tidak Ditemukan</h3><p style="color:var(--text-muted);">Coba kata kunci lain atau hapus filter.</p><a href="<?php echo e(route('tips')); ?>" class="btn btn-primary" style="margin-top:16px;">Lihat Semua</a></div>
<?php else: ?>
<div class="ag">
    <?php $__currentLoopData = $artikels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('tips.show',$ar->id)); ?>" class="ac">
            <div class="ac-img-wrap">
            <?php $img = $ar->gambar ? (filter_var($ar->gambar, FILTER_VALIDATE_URL) ? $ar->gambar : asset('storage/'.$ar->gambar)) : 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=600'; ?>
            <img src="<?php echo e($img); ?>" alt="<?php echo e($ar->judul); ?>" class="ac-img">
            <span class="ac-kat"><?php echo e($ar->kategori); ?></span>
        </div>
        <div class="ac-body">
            <div class="ac-meta">
                <div class="ac-meta-item"><i class="fa-regular fa-clock"></i> <?php echo e($ar->waktu_baca); ?> menit</div>
                <div class="ac-meta-item"><i class="fa-regular fa-user"></i> <?php echo e($ar->penulis); ?></div>
            </div>
            <div class="ac-judul"><?php echo e($ar->judul); ?></div>
            <div class="ac-ring"><?php echo e($ar->ringkasan); ?></div>
            <div class="ac-footer">
                <span class="ac-date"><?php echo e($ar->formatted_date); ?></span>
                <span class="ac-more">Baca Selengkapnya →</span>
            </div>
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php if($artikels->hasPages()): ?>
<div style="display:flex;justify-content:center;gap:6px;margin-bottom:32px;">
    <?php if(!$artikels->onFirstPage()): ?><a href="<?php echo e($artikels->previousPageUrl()); ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-left"></i></a><?php endif; ?>
    <span style="display:flex;align-items:center;font-size:.875rem;color:var(--text-muted);padding:0 12px;">Hal <?php echo e($artikels->currentPage()); ?> / <?php echo e($artikels->lastPage()); ?></span>
    <?php if($artikels->hasMorePages()): ?><a href="<?php echo e($artikels->nextPageUrl()); ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-right"></i></a><?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/pages/tips.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/pages/tips.blade.php ENDPATH**/ ?>