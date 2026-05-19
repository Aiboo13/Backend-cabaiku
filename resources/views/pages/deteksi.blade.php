@extends('layouts.app')
@section('title','Deteksi Penyakit')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/deteksi.css') }}">
@endsection
@section('content')
<div class="page-header">
    <h1>🔬 Deteksi Penyakit Cabai</h1>
    <p>Upload foto tanaman cabai untuk mendeteksi penyakit secara otomatis</p>
</div>

@if($lahans->isEmpty())
<div class="card"><div class="card-body" style="text-align:center;padding:36px;">
    <div style="font-size:2.5rem;margin-bottom:12px;">🌿</div>
    <div style="font-weight:700;margin-bottom:8px;">Belum Ada Lahan Terdaftar</div>
    <p style="font-size:.875rem;color:var(--text-muted);margin-bottom:20px;">Silakan tambahkan lahan terlebih dahulu di halaman Beranda.</p>
    <a href="{{ route('beranda') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lahan</a>
</div></div>
@else
<form method="POST" action="{{ route('deteksi.store') }}" enctype="multipart/form-data" id="deteksi-form">
    @csrf
    <!-- Pilih Lahan -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title"><i class="fa-solid fa-map-location-dot" style="color:var(--primary);margin-right:8px;"></i>Pilih Lahan</span></div>
        <div class="card-body">
            <p style="font-size:.83rem;color:var(--text-muted);margin-bottom:14px;">Pilih lahan yang akan dilakukan deteksi</p>
            @error('lahan_id')<div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:10px 14px;border-radius:8px;font-size:.83rem;margin-bottom:12px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
            @foreach($lahans as $lahan)
            <label class="lahan-opt {{ old('lahan_id')==$lahan->id ? 'sel' : '' }}" id="lo-{{ $lahan->id }}">
                <input type="radio" name="lahan_id" value="{{ $lahan->id }}" {{ old('lahan_id')==$lahan->id ? 'checked' : '' }} onchange="selLahan({{ $lahan->id }})">
                <div class="lahan-opt-icon"><i class="fa-solid fa-leaf"></i></div>
                <div style="flex:1;">
                    <div class="lahan-opt-name">{{ $lahan->nama_lahan }}</div>
                    <div class="lahan-opt-sub"><i class="fa-solid fa-location-dot"></i> {{ $lahan->lokasi }}{{ $lahan->panjang ? ' · '.$lahan->panjang.' m' : '' }}</div>
                </div>
                <i class="fa-solid fa-circle-check" style="color:var(--primary);opacity:{{ old('lahan_id')==$lahan->id ? 1 : 0 }};" id="chk-{{ $lahan->id }}"></i>
            </label>
            @endforeach
        </div>
    </div>

    <!-- Upload Gambar -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title"><i class="fa-solid fa-image" style="color:var(--primary);margin-right:8px;"></i>Upload Foto Tanaman</span></div>
        <div class="card-body">
            @error('gambar')<div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:10px 14px;border-radius:8px;font-size:.83rem;margin-bottom:12px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
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
                <textarea name="catatan" class="form-control" placeholder="cth: Daun mulai menguning sejak 3 hari lalu...">{{ old('catatan') }}</textarea>
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
@endif
@endsection
@section('scripts')
<script src="{{ asset('js/pages/deteksi.js') }}"></script>
@endsection
