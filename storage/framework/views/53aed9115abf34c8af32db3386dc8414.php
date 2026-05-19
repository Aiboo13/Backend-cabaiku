
<?php $__env->startSection('title','Riwayat Deteksi'); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/riwayat.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header"><h1>🗂️ Riwayat Deteksi</h1><p>Lihat semua hasil deteksi penyakit tanaman cabai Anda</p></div>
<div class="stat-row">
    <div class="sb"><div class="sb-num"><?php echo e($totalDeteksi); ?></div><div class="sb-label">Total Deteksi</div></div>
    <div class="sb"><div class="sb-num g"><i class="fa-solid fa-circle-check" style="font-size:1.2rem;"></i> <?php echo e($tanamanSehat); ?></div><div class="sb-label">Tanaman Sehat</div></div>
    <div class="sb"><div class="sb-num r"><i class="fa-solid fa-circle-exclamation" style="font-size:1.2rem;"></i> <?php echo e($terdeteksiPenyakit); ?></div><div class="sb-label">Terdeteksi Penyakit</div></div>
</div>
<?php if($riwayats->isEmpty()): ?>
<div class="empty"><div style="font-size:3rem;margin-bottom:16px;opacity:.4;">📷</div><h3 style="font-weight:700;margin-bottom:8px;">Belum Ada Riwayat</h3><p style="color:var(--text-muted);margin-bottom:20px;">Anda belum melakukan deteksi penyakit.</p><a href="<?php echo e(route('deteksi')); ?>" class="btn btn-primary"><i class="fa-solid fa-camera"></i> Mulai Deteksi</a></div>
<?php else: ?>
<div class="rlist">
    <?php $__currentLoopData = $riwayats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $isS=$r->hasil==='Sehat'; $isB=$r->tingkat_keparahan==='Berat'; $ic=$isS?'sehat':($isB?'berat':'sakit'); $em=$isS?'✅':($isB?'🚨':'⚠️'); ?>
    <div class="ritem">
        <div class="ricon <?php echo e($ic); ?>"><?php echo e($em); ?></div>
        <div class="rcontent">
            <div class="rhasil"><?php echo e($r->hasil); ?></div>
            <div class="rmeta">
                <span class="badge badge-<?php echo e(strtolower($r->tingkat_keparahan)); ?>"><?php echo e($r->tingkat_keparahan); ?></span>
                <div class="rmeta-item"><i class="fa-solid fa-bullseye"></i> <?php echo e($r->akurasi); ?>%</div>
                <div class="rmeta-item"><i class="fa-regular fa-calendar"></i> <?php echo e($r->created_at->translatedFormat('d M Y')); ?></div>
                <div class="rmeta-item"><i class="fa-regular fa-clock"></i> <?php echo e($r->created_at->format('H:i')); ?></div>
                <?php if($r->lahan): ?><div class="rmeta-item"><i class="fa-solid fa-location-dot"></i> <?php echo e($r->lahan->nama_lahan); ?></div><?php endif; ?>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('riwayat.destroy',$r->id)); ?>" onsubmit="return confirm('Hapus riwayat ini?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="del-btn"><i class="fa-solid fa-trash"></i></button>
        </form>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php if($riwayats->hasPages()): ?>
<div style="display:flex;justify-content:center;gap:6px;margin-bottom:32px;">
    <?php if(!$riwayats->onFirstPage()): ?><a href="<?php echo e($riwayats->previousPageUrl()); ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-left"></i></a><?php endif; ?>
    <span style="display:flex;align-items:center;font-size:.875rem;color:var(--text-muted);padding:0 12px;">Hal <?php echo e($riwayats->currentPage()); ?> / <?php echo e($riwayats->lastPage()); ?></span>
    <?php if($riwayats->hasMorePages()): ?><a href="<?php echo e($riwayats->nextPageUrl()); ?>" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-right"></i></a><?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/pages/riwayat.blade.php ENDPATH**/ ?>