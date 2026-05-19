<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>
    <form class="card" method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <h1>Login Admin</h1>
        <p>Panel khusus pengelolaan aplikasi.</p>
        @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
        @if(session('success'))<div class="err" style="background:#ecfdf5;border-color:#a7f3d0;color:#065f46">{{ session('success') }}</div>@endif
        <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="field"><label>Password</label><input type="password" name="password" required></div>
        <div class="field"><label><input type="checkbox" name="remember"> Ingat saya</label></div>
        <button type="submit" class="btn">Masuk Admin</button>
    </form>
</body>
</html>
