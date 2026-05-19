
<?php $__env->startSection('title','Deteksi Penyakit'); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/deteksi.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>🔬 Deteksi Penyakit Cabai</h1>
    <p>Upload foto tanaman cabai untuk mendeteksi penyakit secara otomatis</p>
</div>

<?php if($lahans->isEmpty()): ?>
<div class="card"><div class="card-body" style="text-align:center;padding:36px;">
    <div style="font-size:2.5rem;margin-bottom:12px;">🌿</div>
    <div style="font-weight:700;margin-bottom:8px;">Belum Ada Lahan Terdaftar</div>
    <p style="font-size:.875rem;color:var(--text-muted);margin-bottom:20px;">Silakan tambahkan lahan terlebih dahulu di halaman Beranda.</p>
    <a href="<?php echo e(route('beranda')); ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lahan</a>
</div></div>
<?php else: ?>
<form method="POST" action="<?php echo e(route('deteksi.store')); ?>" enctype="multipart/form-data" id="deteksi-form">
    <?php echo csrf_field(); ?>
    <!-- Pilih Lahan -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title"><i class="fa-solid fa-map-location-dot" style="color:var(--primary);margin-right:8px;"></i>Pilih Lahan</span></div>
        <div class="card-body">
            <p style="font-size:.83rem;color:var(--text-muted);margin-bottom:14px;">Pilih lahan yang akan dilakukan deteksi</p>
            <?php $__errorArgs = ['lahan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:10px 14px;border-radius:8px;font-size:.83rem;margin-bottom:12px;"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__currentLoopData = $lahans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lahan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="lahan-opt <?php echo e(old('lahan_id')==$lahan->id ? 'sel' : ''); ?>" id="lo-<?php echo e($lahan->id); ?>">
                <input type="radio" name="lahan_id" value="<?php echo e($lahan->id); ?>" <?php echo e(old('lahan_id')==$lahan->id ? 'checked' : ''); ?> onchange="selLahan(<?php echo e($lahan->id); ?>)">
                <div class="lahan-opt-icon"><i class="fa-solid fa-leaf"></i></div>
                <div style="flex:1;">
                    <div class="lahan-opt-name"><?php echo e($lahan->nama_lahan); ?></div>
                    <div class="lahan-opt-sub"><i class="fa-solid fa-location-dot"></i> <?php echo e($lahan->lokasi); ?><?php echo e($lahan->panjang ? ' · '.$lahan->panjang.' m' : ''); ?></div>
                </div>
                <i class="fa-solid fa-circle-check" style="color:var(--primary);opacity:<?php echo e(old('lahan_id')==$lahan->id ? 1 : 0); ?>;" id="chk-<?php echo e($lahan->id); ?>"></i>
            </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Upload Gambar -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title"><i class="fa-solid fa-image" style="color:var(--primary);margin-right:8px;"></i>Upload Foto Tanaman</span></div>
        <div class="card-body">
            <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:10px 14px;border-radius:8px;font-size:.83rem;margin-bottom:12px;"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div id="upload-area">
                <div class="upload-zone" id="drop-zone">
                    <input type="file" name="gambar" id="gambar-inp" accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this)">
                    <div class="upload-icon">📷</div>
                    <div class="upload-title">Klik atau seret foto di sini</div>
                    <div class="upload-sub">Upload foto bagian tanaman yang ingin dideteksi</div>
                    <div class="upload-fmt">Format: JPG, JPEG, PNG, WEBP · Maks. 5MB</div>
                </div>
            </div>
            <div id="preview-area" style="display:none;" class="preview-wrap">
                <img id="preview-img" src="" alt="Preview" class="preview-img">
                <button type="button" class="remove-preview" onclick="removePreview()"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>

    <!-- Catatan -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-body">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label"><i class="fa-solid fa-note-sticky" style="color:var(--text-muted);margin-right:6px;"></i>Catatan (Opsional)</label>
                <textarea name="catatan" class="form-control" placeholder="cth: Daun mulai menguning sejak 3 hari lalu..."><?php echo e(old('catatan')); ?></textarea>
            </div>
        </div>
    </div>

    <div class="tips-box">
        <div class="tips-box-title"><i class="fa-solid fa-circle-info"></i> Tips Foto Terbaik</div>
        <div class="tip-item"><div class="tip-dot"></div><span>Ambil foto dengan pencahayaan yang cukup, hindari bayangan</span></div>
        <div class="tip-item"><div class="tip-dot"></div><span>Fokuskan pada bagian tanaman yang menunjukkan gejala</span></div>
        <div class="tip-item"><div class="tip-dot"></div><span>Pastikan foto tidak buram atau terlalu gelap</span></div>
        <div class="tip-item"><div class="tip-dot"></div><span>Ambil dari jarak 20-30 cm untuk detail yang jelas</span></div>
    </div>

    <div style="margin-top:20px;margin-bottom:12px;">
        <button type="submit" class="btn btn-primary btn-block btn-lg" id="submit-btn">
            <i class="fa-solid fa-magnifying-glass"></i> Mulai Deteksi Sekarang
        </button>
    </div>
</form>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/pages/deteksi.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/pages/deteksi.blade.php ENDPATH**/ ?>