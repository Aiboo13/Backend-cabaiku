<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-login.css')); ?>">
</head>
<body>
    <form class="card" method="POST" action="<?php echo e(route('admin.login.post')); ?>">
        <?php echo csrf_field(); ?>
        <h1>Login Admin</h1>
        <p>Panel khusus pengelolaan aplikasi.</p>
        <?php if($errors->any()): ?><div class="err"><?php echo e($errors->first()); ?></div><?php endif; ?>
        <?php if(session('success')): ?><div class="err" style="background:#ecfdf5;border-color:#a7f3d0;color:#065f46"><?php echo e(session('success')); ?></div><?php endif; ?>
        <div class="field"><label>Email</label><input type="email" name="email" value="<?php echo e(old('email')); ?>" required></div>
        <div class="field"><label>Password</label><input type="password" name="password" required></div>
        <div class="field"><label><input type="checkbox" name="remember"> Ingat saya</label></div>
        <button type="submit" class="btn">Masuk Admin</button>
    </form>
</body>
</html>
<?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>