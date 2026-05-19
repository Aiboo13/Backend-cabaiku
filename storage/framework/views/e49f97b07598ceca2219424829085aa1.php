
<?php $__env->startSection('title','Beranda'); ?>
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/pages/beranda.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="hero">
    <div class="hero-greeting">👋 Halo,</div>
    <h1 class="hero-title">Selamat Datang,<br><?php echo e(auth()->user()->name); ?>!</h1>
    <p class="hero-sub">Mari pantau & jaga kesehatan tanaman cabai Anda</p>
    <a href="<?php echo e(route('deteksi')); ?>" class="btn-hero"><i class="fa-solid fa-camera"></i> Deteksi Penyakit Sekarang</a>
</div>

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon si-blue"><i class="fa-solid fa-camera"></i></div><div><div class="stat-num"><?php echo e($totalDeteksi); ?></div><div class="stat-label">Total Deteksi</div></div></div>
    <div class="stat-card"><div class="stat-icon si-green"><i class="fa-solid fa-circle-check"></i></div><div><div class="stat-num"><?php echo e($tanamanSehat); ?></div><div class="stat-label">Tanaman Sehat</div></div></div>
    <div class="stat-card"><div class="stat-icon si-orange"><i class="fa-solid fa-circle-exclamation"></i></div><div><div class="stat-num"><?php echo e($perluPerhatian); ?></div><div class="stat-label">Perlu Perhatian</div></div></div>
</div>

<div class="sec-header">
    <span class="sec-title">🌿 Lahan Saya</span>
    <button class="btn btn-primary btn-sm" onclick="openModal('m-lahan')"><i class="fa-solid fa-plus"></i> Tambah Lahan</button>
</div>

<?php if($lahans->isEmpty()): ?>
<div class="lahan-empty">
    <div class="lahan-empty-icon">📍</div>
    <p>Belum ada lahan terdaftar.<br>Tambahkan lahan pertama Anda!</p>
    <button class="btn btn-primary" onclick="openModal('m-lahan')"><i class="fa-solid fa-plus"></i> Tambah Lahan Pertama</button>
</div>
<?php else: ?>
<div class="lahan-grid">
    <?php $__currentLoopData = $lahans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lahan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="lahan-card">
        <div class="lahan-name"><?php echo e($lahan->nama_lahan); ?></div>
        <div class="lahan-loc"><i class="fa-solid fa-location-dot"></i> <?php echo e($lahan->lokasi); ?></div>
        <?php if($lahan->lebar || $lahan->panjang): ?>
        <div class="lahan-dim">
            <i class="fa-solid fa-ruler-horizontal"></i>
            <span>
                <?php if($lahan->lebar): ?> Lebar: <?php echo e($lahan->lebar); ?> m <?php endif; ?>
                <?php if($lahan->lebar && $lahan->panjang): ?> | <?php endif; ?>
                <?php if($lahan->panjang): ?> Panjang: <?php echo e($lahan->panjang); ?> m <?php endif; ?>
            </span>
        </div>
        <?php endif; ?>
        <div class="lahan-footer">
            <div class="lahan-count"><strong><?php echo e($lahan->deteksis_count); ?></strong> deteksi</div>
            <div class="lahan-actions">
                <button
                    type="button"
                    class="edit-lahan"
                    onclick="openEditLahanModal(this)"
                    data-id="<?php echo e($lahan->id); ?>"
                    data-nama_lahan="<?php echo e($lahan->nama_lahan); ?>"
                    data-lokasi="<?php echo e($lahan->lokasi); ?>"
                    data-lebar="<?php echo e($lahan->lebar); ?>"
                    data-panjang="<?php echo e($lahan->panjang); ?>"
                    data-keterangan="<?php echo e($lahan->keterangan); ?>"
                    title="Edit lahan"
                >
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form method="POST" action="<?php echo e(route('lahan.destroy',$lahan->id)); ?>" onsubmit="return confirm('Hapus lahan ini?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="del-lahan"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="quick-grid">
    <a href="<?php echo e(route('deteksi')); ?>" class="quick-card">
        <div class="quick-icon qi-red"><i class="fa-solid fa-camera"></i></div>
        <div><div class="quick-label">Deteksi Penyakit</div><div class="quick-sub">Scan tanaman cabai Anda</div></div>
    </a>
    <a href="<?php echo e(route('tips')); ?>" class="quick-card">
        <div class="quick-icon qi-blue"><i class="fa-solid fa-book-open"></i></div>
        <div><div class="quick-label">Tips Perawatan</div><div class="quick-sub">Artikel & panduan lengkap</div></div>
    </a>
</div>

<div class="tip-card">
    <div class="tip-icon">💡</div>
    <div>
        <div class="tip-title">Tips Hari Ini untuk Merawat Tanaman Cabai</div>
        <div class="tip-text"><?php echo e($tipHariIni); ?></div>
    </div>
</div>

<div class="sec-header">
    <span class="sec-title">📰 Artikel Terbaru</span>
    <a href="<?php echo e(route('tips')); ?>" class="sec-link">Lihat Semua →</a>
</div>
<div class="artikel-grid">
    <?php $__currentLoopData = $artikelTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('tips.show',$ar->id)); ?>" class="a-card">
        <img src="<?php echo e($ar->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=500'); ?>" alt="<?php echo e($ar->judul); ?>" class="a-img">
        <div class="a-body">
            <div class="a-meta"><span class="a-kat"><?php echo e($ar->kategori); ?></span><span class="a-waktu"><i class="fa-regular fa-clock"></i> <?php echo e($ar->waktu_baca); ?> mnt</span></div>
            <div class="a-judul"><?php echo e($ar->judul); ?></div>
            <div class="a-ring"><?php echo e($ar->ringkasan); ?></div>
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Modal Tambah Lahan -->
<div class="modal-overlay" id="m-lahan">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Tambah Lahan Baru</span>
            <button class="modal-close" onclick="closeModal('m-lahan')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('lahan.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lahan <span style="color:#EF4444">*</span></label>
                    <input type="text" name="nama_lahan" class="form-control <?php $__errorArgs = ['nama_lahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="cth: Lahan Utama Blok A" value="<?php echo e(old('nama_lahan')); ?>" required>
                    <?php $__errorArgs = ['nama_lahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:#EF4444">*</span></label>
                    <input type="text" name="lokasi" class="form-control <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="cth: Brebes, Jawa Tengah" value="<?php echo e(old('lokasi')); ?>" required>
                    <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Lebar Lahan (m)</label>
                    <input type="number" name="lebar" class="form-control" step="0.01" min="0" placeholder="cth: 20" value="<?php echo e(old('lebar')); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Panjang Lahan (m)</label>
                    <input type="number" name="panjang" class="form-control" step="0.01" min="0" placeholder="cth: 30" value="<?php echo e(old('panjang')); ?>">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" placeholder="Keterangan tambahan..."><?php echo e(old('keterangan')); ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('m-lahan')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Lahan -->
<div class="modal-overlay" id="m-lahan-edit">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Edit Lahan</span>
            <button class="modal-close" onclick="closeModal('m-lahan-edit')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="edit-lahan-form" method="POST" action="<?php echo e(route('lahan.update', old('lahan_id', 0))); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" id="edit-lahan-id" name="lahan_id" value="<?php echo e(old('lahan_id')); ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lahan</label>
                    <input type="text" id="edit-nama-lahan" name="nama_lahan" class="form-control <?php $__errorArgs = ['nama_lahan','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="cth: Lahan Utama Blok A" value="<?php echo e(old('nama_lahan')); ?>">
                    <?php $__errorArgs = ['nama_lahan','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi</label>
                    <input type="text" id="edit-lokasi" name="lokasi" class="form-control <?php $__errorArgs = ['lokasi','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="cth: Brebes, Jawa Tengah" value="<?php echo e(old('lokasi')); ?>">
                    <?php $__errorArgs = ['lokasi','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Lebar Lahan (m)</label>
                    <input type="number" id="edit-lebar" name="lebar" class="form-control <?php $__errorArgs = ['lebar','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" step="0.01" min="0" placeholder="cth: 20" value="<?php echo e(old('lebar')); ?>">
                    <?php $__errorArgs = ['lebar','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Panjang Lahan (m)</label>
                    <input type="number" id="edit-panjang" name="panjang" class="form-control <?php $__errorArgs = ['panjang','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" step="0.01" min="0" placeholder="cth: 30" value="<?php echo e(old('panjang')); ?>">
                    <?php $__errorArgs = ['panjang','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Keterangan</label>
                    <textarea id="edit-keterangan" name="keterangan" class="form-control <?php $__errorArgs = ['keterangan','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Keterangan tambahan..."><?php echo e(old('keterangan')); ?></textarea>
                    <?php $__errorArgs = ['keterangan','updateLahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('m-lahan-edit')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
window.lahanBaseUrl = "<?php echo e(url('/lahan')); ?>";
window.hasCreateLahanError = <?php echo e(($errors->has('nama_lahan') || $errors->has('lokasi')) ? 'true' : 'false'); ?>;
window.hasUpdateLahanError = <?php echo e($errors->updateLahan->any() ? 'true' : 'false'); ?>;
</script>
<script src="<?php echo e(asset('js/pages/beranda.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/pages/beranda.blade.php ENDPATH**/ ?>