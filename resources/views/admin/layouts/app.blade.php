<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Cabaiku')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="wrap">
    <div class="nav">
        <a href="{{ route('admin.dashboard') }}" class="brand">Admin Cabaiku</a>
        <div class="menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.artikels.index') }}" class="{{ request()->routeIs('admin.artikels.*') ? 'active' : '' }}">Artikel</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="btn btn-danger">Logout</button></form>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif

    @yield('content')
</div>
</body>
</html>
