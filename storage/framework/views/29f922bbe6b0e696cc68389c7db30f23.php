<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Cabaiku'); ?> — Deteksi Penyakit Cabai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <nav class="top-nav">
        <a href="<?php echo e(route('beranda')); ?>" class="brand">Cabai<span>ku</span></a>
    </nav>

    <div class="main-wrapper">
        <div class="page-container">
            <?php if(session('success')): ?>
            <div class="alert alert-success" id="flash-ok">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo e(session('success')); ?></span>
                <span class="alert-close" onclick="this.closest('.alert').remove()"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
            <div class="alert alert-error" id="flash-err">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?php echo e(session('error')); ?></span>
                <span class="alert-close" onclick="this.closest('.alert').remove()"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <?php endif; ?>
            <?php if(session('info')): ?>
            <div class="alert alert-info" id="flash-info">
                <i class="fa-solid fa-circle-info"></i>
                <span><?php echo e(session('info')); ?></span>
                <span class="alert-close" onclick="this.closest('.alert').remove()"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="<?php echo e(route('beranda')); ?>"  class="nav-item <?php echo e(request()->routeIs('beranda')   ? 'active' : ''); ?>"><i class="fa-solid fa-house"></i><span>Beranda</span></a>
        <a href="<?php echo e(route('deteksi')); ?>"  class="nav-item <?php echo e(request()->routeIs('deteksi*')  ? 'active' : ''); ?>"><i class="fa-solid fa-camera"></i><span>Deteksi</span></a>
        <a href="<?php echo e(route('tips')); ?>"     class="nav-item <?php echo e(request()->routeIs('tips*')     ? 'active' : ''); ?>"><i class="fa-solid fa-book-open"></i><span>Tips</span></a>
        <a href="<?php echo e(route('riwayat')); ?>"  class="nav-item <?php echo e(request()->routeIs('riwayat*')  ? 'active' : ''); ?>"><i class="fa-solid fa-clock-rotate-left"></i><span>Riwayat</span></a>
        <a href="<?php echo e(route('profil')); ?>"   class="nav-item <?php echo e(request()->routeIs('profil*')   ? 'active' : ''); ?>"><i class="fa-solid fa-user"></i><span>Profil</span></a>
    </nav>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/layouts/app.blade.php ENDPATH**/ ?>