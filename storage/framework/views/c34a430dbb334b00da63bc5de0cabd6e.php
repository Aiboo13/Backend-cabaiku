<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Cabaiku'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
</head>
<body>
<div class="wrap">
    <div class="nav">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand">Admin Cabaiku</a>
        <div class="menu">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">Dashboard</a>
            <a href="<?php echo e(route('admin.artikels.index')); ?>" class="<?php echo e(request()->routeIs('admin.artikels.*') ? 'active' : ''); ?>">Artikel</a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>"><?php echo csrf_field(); ?><button type="submit" class="btn btn-danger">Logout</button></form>
        </div>
    </div>

    <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
    <?php if($errors->any()): ?><div class="alert alert-error"><?php echo e($errors->first()); ?></div><?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</div>
</body>
</html>
<?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>