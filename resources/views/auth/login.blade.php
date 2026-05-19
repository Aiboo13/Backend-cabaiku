<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Cabaiku</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="split">
    <div class="visual">
        <div class="vc">
            <div class="vc-logo">Cabai<span>ku</span></div>
            <h1>Jaga Kesehatan Tanaman Cabaimu</h1>
            <p>Deteksi penyakit secara otomatis, pantau lahan, dan dapatkan panduan dari para ahli.</p>
            <div class="feat-list">
                <div class="feat"><div class="feat-icon">🔬</div><div class="feat-text"><strong>Deteksi AI Akurat</strong><span>Identifikasi penyakit dengan akurasi tinggi</span></div></div>
                <div class="feat"><div class="feat-icon">🌱</div><div class="feat-text"><strong>Panduan Lengkap</strong><span>Tips & artikel dari pakar agronomi</span></div></div>
                <div class="feat"><div class="feat-icon">📊</div><div class="feat-text"><strong>Riwayat Deteksi</strong><span>Pantau perkembangan kesehatan tanaman</span></div></div>
            </div>
        </div>
    </div>
    <div class="form-panel">
        <div class="form-inner">
            <a href="{{ route('home', [], false) }}" class="mobile-logo">🌶️ Cabaiku</a>
            <div class="form-title">Selamat Datang!</div>
            <div class="form-sub">Masuk ke akun Cabaiku Anda</div>

            @if($errors->any())
            <div class="alert-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post', [], false) }}">
                @csrf
                <div class="fg">
                    <label class="lbl">Email</label>
                    <div class="inp-wrap">
                        <i class="fa-solid fa-envelope inp-icon"></i>
                        <input type="email" name="email" class="inp {{ $errors->has('email') ? 'err' : '' }}" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="fg">
                    <label class="lbl">Password</label>
                    <div class="inp-wrap">
                        <i class="fa-solid fa-lock inp-icon"></i>
                        <input type="password" name="password" id="pw" class="inp" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('pw',this)"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="rem-row">
                    <label class="rem-label"><input type="checkbox" name="remember"> Ingat saya</label>
                </div>
                <button type="submit" class="btn-sub"><i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i>Masuk</button>
            </form>
            <div class="divider"><span>atau</span></div>
            <div class="switch">Belum punya akun? <a href="{{ route('register', [], false) }}">Daftar Sekarang</a></div>
        </div>
    </div>
</div>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
