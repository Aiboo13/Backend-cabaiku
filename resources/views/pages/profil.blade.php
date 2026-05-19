@extends('layouts.app')
@section('title','Profil Saya')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/profil.css') }}">
@endsection
@section('content')
<div class="page-header"><h1>👤 Profil Saya</h1><p>Kelola informasi akun Anda</p></div>

<div class="pcard">
    <div class="pheader">
        <div class="pavatar">{{ strtoupper(substr($user->name,0,1)) }}{{ strtoupper(substr(strstr($user->name.' ',' '),1,1)) }}</div>
        <div class="pname">{{ $user->name }}</div>
        <div class="psince">Bergabung sejak {{ $user->created_at->translatedFormat('F Y') }}</div>
    </div>
    <div class="pstats" style="display:flex;justify-content:center;gap:2rem;">
        <div class="pstat"><div class="pstat-num">{{ $totalDeteksi }}</div><div class="pstat-label">Total Deteksi</div></div>
        <div class="pstat"><div class="pstat-num">{{ $hariAktif }}</div><div class="pstat-label">Hari Aktif</div></div>
    </div>
    <div class="info-list">
        <div class="irow"><div class="irow-icon"><i class="fa-solid fa-user"></i></div><div><div class="irow-label">Nama Lengkap</div><div class="irow-val">{{ $user->name }}</div></div></div>
        <div class="irow"><div class="irow-icon"><i class="fa-solid fa-envelope"></i></div><div><div class="irow-label">Email</div><div class="irow-val">{{ $user->email }}</div></div></div>
        <div class="irow"><div class="irow-icon"><i class="fa-solid fa-phone"></i></div><div><div class="irow-label">No. Telepon</div><div class="irow-val">{{ $user->phone ?? '-' }}</div></div></div>
        <div class="irow"><div class="irow-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="irow-label">Lokasi</div><div class="irow-val">{{ $user->location ?? '-' }}</div></div></div>
    </div>
    <button class="edit-btn" onclick="toggleSec('edit')"><i class="fa-solid fa-pen-to-square"></i> Edit Profil</button>
</div>

<!-- Edit Profil -->
<div class="sec" id="sec-edit" style="display:none;">
    <div class="sec-hd open"><div class="sec-ic si-r"><i class="fa-solid fa-pen"></i></div><span class="sec-label">Edit Informasi Profil</span><i class="fa-solid fa-chevron-down sec-chev" style="transform:rotate(180deg);"></i></div>
    <div class="sec-body open">
        <form method="POST" action="{{ route('profil.update') }}">@csrf
            <div class="form-group"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" required>@error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
            <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" required>@error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
            <div class="form-group"><label class="form-label">No. Telepon</label><input type="tel" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}" placeholder="08xxxxxxxxxx"></div>
            <div class="form-group" style="margin-bottom:0;"><label class="form-label">Lokasi / Kota</label><input type="text" name="location" class="form-control" value="{{ old('location',$user->location) }}" placeholder="Kota, Provinsi"></div>
            <div style="margin-top:16px;"><button type="submit" class="btn btn-primary btn-block"><i class="fa-solid fa-check"></i> Simpan Perubahan</button></div>
        </form>
    </div>
</div>

<!-- Ubah Password -->
<div class="sec">
    <div class="sec-hd" onclick="toggleSec('pw')"><div class="sec-ic si-b"><i class="fa-solid fa-lock"></i></div><span class="sec-label">Ubah Password</span><i class="fa-solid fa-chevron-down sec-chev" id="chev-pw"></i></div>
    <div class="sec-body" id="body-pw">
        <form method="POST" action="{{ route('profil.password') }}" onsubmit="return confirm('Apakah Anda yakin ingin mengubah password?')">@csrf
            <div class="form-group"><label class="form-label">Password Saat Ini</label><div style="position:relative;"><input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password lama"><button type="button" class="pwd-toggle" onclick="togglePwdVis('current_password')" title="Tampilkan password"><i class="fa-solid fa-eye"></i></button></div>@error('current_password')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
            <div class="form-group"><label class="form-label">Password Baru</label><div style="position:relative;"><input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 karakter"><button type="button" class="pwd-toggle" onclick="togglePwdVis('password')" title="Tampilkan password"><i class="fa-solid fa-eye"></i></button></div>@error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror</div>
            <div class="form-group" style="margin-bottom:0;"><label class="form-label">Konfirmasi Password Baru</label><div style="position:relative;"><input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru"><button type="button" class="pwd-toggle" onclick="togglePwdVis('password_confirmation')" title="Tampilkan password"><i class="fa-solid fa-eye"></i></button></div></div>
            <div style="margin-top:16px;"><button type="submit" class="btn btn-primary btn-block"><i class="fa-solid fa-shield-halved"></i> Ubah Password</button></div>
        </form>
    </div>

<style>
.pwd-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:1rem;padding:4px 8px;transition:all .2s;}
.pwd-toggle:hover{color:var(--primary);}
.pwd-toggle i{pointer-events:none;}
</style>

<script>
function togglePwdVis(fieldId){const field=document.getElementById(fieldId);const btn=event.target.closest('.pwd-toggle');const icon=btn.querySelector('i');if(field.type==='password'){field.type='text';icon.classList.remove('fa-eye');icon.classList.add('fa-eye-slash');btn.title='Sembunyikan password';}else{field.type='password';icon.classList.remove('fa-eye-slash');icon.classList.add('fa-eye');btn.title='Tampilkan password';}}
</script>
</div>

<!-- Logout -->
<form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar?')">
    @csrf
    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Keluar dari Akun</button>
</form>
@endsection
@section('scripts')
<script>
window.profilHasNameError     = {{ $errors->has('name')             ? 'true' : 'false' }};
window.profilHasEmailError    = {{ $errors->has('email')            ? 'true' : 'false' }};
window.profilHasPasswordError = {{ $errors->has('current_password') || $errors->has('password') ? 'true' : 'false' }};
</script>
<script src="{{ asset('js/pages/profil.js') }}"></script>
@endsection
