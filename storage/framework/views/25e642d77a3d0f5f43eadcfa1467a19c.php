<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Cabaiku</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">
</head>
<body>
<div class="split">
    <div class="visual">
        <div class="vc">
            <div class="vc-logo">Cabai<span>ku</span></div>
            <h1>Mulai Perjalanan Bertanimu</h1>
            <p>Bergabung dengan petani cabai yang merasakan manfaat teknologi AI untuk lahan mereka.</p>
            <div class="steps">
                <div class="step"><div class="step-num">1</div><div><strong>Buat Akun</strong><span>Daftar gratis dalam 1 menit</span></div></div>
                <div class="step"><div class="step-num">2</div><div><strong>Tambah Lahan</strong><span>Daftarkan lahan cabai Anda</span></div></div>
                <div class="step"><div class="step-num">3</div><div><strong>Foto & Deteksi</strong><span>Upload foto, hasil instan</span></div></div>
                <div class="step"><div class="step-num">4</div><div><strong>Ikuti Rekomendasi</strong><span>Tangani penyakit dengan tepat</span></div></div>
            </div>
        </div>
    </div>
    <div class="form-panel">
        <div class="form-inner">
            <a href="<?php echo e(route('home', [], false)); ?>" class="mobile-logo">🌶️ Cabaiku</a>
            <div class="form-title">Buat Akun Baru</div>
            <div class="form-sub">Sudah punya akun? <a href="<?php echo e(route('login', [], false)); ?>">Masuk di sini</a></div>
            <form method="POST" action="<?php echo e(route('register.post', [], false)); ?>">
                <?php echo csrf_field(); ?>
                <div class="sec-label">Informasi Akun</div>
                <div class="fg">
                    <label class="lbl">Nama Lengkap <span style="color:#EF4444">*</span></label>
                    <div class="inp-wrap">
                        <i class="fa-solid fa-user inp-icon"></i>
                        <input type="text" name="name" class="inp <?php echo e($errors->has('name') ? 'err' : ''); ?>" placeholder="Nama lengkap Anda" value="<?php echo e(old('name')); ?>" required>
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fg">
                    <label class="lbl">Email <span style="color:#EF4444">*</span></label>
                    <div class="inp-wrap">
                        <i class="fa-solid fa-envelope inp-icon"></i>
                        <input type="email" name="email" class="inp <?php echo e($errors->has('email') ? 'err' : ''); ?>" placeholder="nama@email.com" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="row2">
                    <div class="fg">
                        <label class="lbl">Password <span style="color:#EF4444">*</span></label>
                        <div class="inp-wrap">
                            <i class="fa-solid fa-lock inp-icon"></i>
                            <input type="password" name="password" id="pw1" class="inp <?php echo e($errors->has('password') ? 'err' : ''); ?>" placeholder="Min. 8 karakter" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('pw1',this)"><i class="fa-solid fa-eye"></i></button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="fg">
                        <label class="lbl">Konfirmasi <span style="color:#EF4444">*</span></label>
                        <div class="inp-wrap">
                            <i class="fa-solid fa-lock inp-icon"></i>
                            <input type="password" name="password_confirmation" id="pw2" class="inp" placeholder="Ulangi password" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('pw2',this)"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="sec-label">Informasi Tambahan (Opsional)</div>
                <div class="row2">
                    <div class="fg">
                        <label class="lbl">No. Telepon</label>
                        <div class="inp-wrap">
                            <i class="fa-solid fa-phone inp-icon"></i>
                            <input type="tel" name="phone" class="inp" placeholder="08xxxxxxxxxx" value="<?php echo e(old('phone')); ?>">
                        </div>
                    </div>
                    <div class="fg">
                        <label class="lbl">Lokasi / Kota</label>
                        <div class="inp-wrap">
                            <i class="fa-solid fa-location-dot inp-icon"></i>
                            <input type="text" name="location" class="inp" placeholder="Kota, Provinsi" value="<?php echo e(old('location')); ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-sub"><i class="fa-solid fa-user-plus" style="margin-right:8px;"></i>Buat Akun Sekarang</button>
            </form>
            <div class="divider"><span>sudah punya akun?</span></div>
            <div class="switch"><a href="<?php echo e(route('login', [], false)); ?>">Masuk ke Cabaiku</a></div>
        </div>
    </div>
</div>
    <script src="<?php echo e(asset('js/auth.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/auth/register.blade.php ENDPATH**/ ?>