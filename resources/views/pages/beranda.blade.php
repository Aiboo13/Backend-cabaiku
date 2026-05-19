@extends('layouts.app')
@section('title','Beranda')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/beranda.css') }}">
@endsection
@section('content')
<div class="hero">
    <div class="hero-greeting">👋 Halo,</div>
    <h1 class="hero-title">Selamat Datang,<br>{{ auth()->user()->name }}!</h1>
    <p class="hero-sub">Mari pantau & jaga kesehatan tanaman cabai Anda</p>
    <a href="{{ route('deteksi') }}" class="btn-hero"><i class="fa-solid fa-camera"></i> Deteksi Penyakit Sekarang</a>
</div>

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon si-blue"><i class="fa-solid fa-camera"></i></div><div><div class="stat-num">{{ $totalDeteksi }}</div><div class="stat-label">Total Deteksi</div></div></div>
    <div class="stat-card"><div class="stat-icon si-green"><i class="fa-solid fa-circle-check"></i></div><div><div class="stat-num">{{ $tanamanSehat }}</div><div class="stat-label">Tanaman Sehat</div></div></div>
    <div class="stat-card"><div class="stat-icon si-orange"><i class="fa-solid fa-circle-exclamation"></i></div><div><div class="stat-num">{{ $perluPerhatian }}</div><div class="stat-label">Perlu Perhatian</div></div></div>
</div>

<div class="sec-header">
    <span class="sec-title">🌿 Lahan Saya</span>
    <button class="btn btn-primary btn-sm" onclick="openModal('m-lahan')"><i class="fa-solid fa-plus"></i> Tambah Lahan</button>
</div>

@if($lahans->isEmpty())
<div class="lahan-empty">
    <div class="lahan-empty-icon">📍</div>
    <p>Belum ada lahan terdaftar.<br>Tambahkan lahan pertama Anda!</p>
    <button class="btn btn-primary" onclick="openModal('m-lahan')"><i class="fa-solid fa-plus"></i> Tambah Lahan Pertama</button>
</div>
@else
<div class="lahan-grid">
    @foreach($lahans as $lahan)
    <div class="lahan-card">
        <div class="lahan-name">{{ $lahan->nama_lahan }}</div>
        <div class="lahan-loc"><i class="fa-solid fa-location-dot"></i> {{ $lahan->lokasi }}</div>
        @if($lahan->lebar || $lahan->panjang)
        <div class="lahan-dim">
            <i class="fa-solid fa-ruler-horizontal"></i>
            <span>
                @if($lahan->lebar) Lebar: {{ $lahan->lebar }} m @endif
                @if($lahan->lebar && $lahan->panjang) | @endif
                @if($lahan->panjang) Panjang: {{ $lahan->panjang }} m @endif
            </span>
        </div>
        @endif
        <div class="lahan-footer">
            <div class="lahan-count"><strong>{{ $lahan->deteksis_count }}</strong> deteksi</div>
            <div class="lahan-actions">
                <button
                    type="button"
                    class="edit-lahan"
                    onclick="openEditLahanModal(this)"
                    data-id="{{ $lahan->id }}"
                    data-nama_lahan="{{ $lahan->nama_lahan }}"
                    data-lokasi="{{ $lahan->lokasi }}"
                    data-lebar="{{ $lahan->lebar }}"
                    data-panjang="{{ $lahan->panjang }}"
                    data-keterangan="{{ $lahan->keterangan }}"
                    title="Edit lahan"
                >
                    <i class="fa-solid fa-pen"></i>
                </button>
                <form method="POST" action="{{ route('lahan.destroy',$lahan->id) }}" onsubmit="return confirm('Hapus lahan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="del-lahan"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="quick-grid">
    <a href="{{ route('deteksi') }}" class="quick-card">
        <div class="quick-icon qi-red"><i class="fa-solid fa-camera"></i></div>
        <div><div class="quick-label">Deteksi Penyakit</div><div class="quick-sub">Scan tanaman cabai Anda</div></div>
    </a>
    <a href="{{ route('tips') }}" class="quick-card">
        <div class="quick-icon qi-blue"><i class="fa-solid fa-book-open"></i></div>
        <div><div class="quick-label">Tips Perawatan</div><div class="quick-sub">Artikel & panduan lengkap</div></div>
    </a>
</div>

<div class="tip-card">
    <div class="tip-icon">💡</div>
    <div>
        <div class="tip-title">Tips Hari Ini untuk Merawat Tanaman Cabai</div>
        <div class="tip-text">{{ $tipHariIni }}</div>
    </div>
</div>

<div class="sec-header">
    <span class="sec-title">📰 Artikel Terbaru</span>
    <a href="{{ route('tips') }}" class="sec-link">Lihat Semua →</a>
</div>
<div class="artikel-grid">
    @foreach($artikelTerbaru as $ar)
    <a href="{{ route('tips.show',$ar->id) }}" class="a-card">
        <img src="{{ $ar->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=500' }}" alt="{{ $ar->judul }}" class="a-img">
        <div class="a-body">
            <div class="a-meta"><span class="a-kat">{{ $ar->kategori }}</span><span class="a-waktu"><i class="fa-regular fa-clock"></i> {{ $ar->waktu_baca }} mnt</span></div>
            <div class="a-judul">{{ $ar->judul }}</div>
            <div class="a-ring">{{ $ar->ringkasan }}</div>
        </div>
    </a>
    @endforeach
</div>

<!-- Modal Tambah Lahan -->
<div class="modal-overlay" id="m-lahan">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Tambah Lahan Baru</span>
            <button class="modal-close" onclick="closeModal('m-lahan')"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('lahan.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lahan <span style="color:#EF4444">*</span></label>
                    <input type="text" name="nama_lahan" class="form-control @error('nama_lahan') is-invalid @enderror" placeholder="cth: Lahan Utama Blok A" value="{{ old('nama_lahan') }}" required>
                    @error('nama_lahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi <span style="color:#EF4444">*</span></label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="cth: Brebes, Jawa Tengah" value="{{ old('lokasi') }}" required>
                    @error('lokasi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Lebar Lahan (m)</label>
                    <input type="number" name="lebar" class="form-control" step="0.01" min="0" placeholder="cth: 20" value="{{ old('lebar') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Panjang Lahan (m)</label>
                    <input type="number" name="panjang" class="form-control" step="0.01" min="0" placeholder="cth: 30" value="{{ old('panjang') }}">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
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
        <form id="edit-lahan-form" method="POST" action="{{ route('lahan.update', old('lahan_id', 0)) }}">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-lahan-id" name="lahan_id" value="{{ old('lahan_id') }}">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lahan</label>
                    <input type="text" id="edit-nama-lahan" name="nama_lahan" class="form-control @error('nama_lahan','updateLahan') is-invalid @enderror" placeholder="cth: Lahan Utama Blok A" value="{{ old('nama_lahan') }}">
                    @error('nama_lahan','updateLahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi</label>
                    <input type="text" id="edit-lokasi" name="lokasi" class="form-control @error('lokasi','updateLahan') is-invalid @enderror" placeholder="cth: Brebes, Jawa Tengah" value="{{ old('lokasi') }}">
                    @error('lokasi','updateLahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Lebar Lahan (m)</label>
                    <input type="number" id="edit-lebar" name="lebar" class="form-control @error('lebar','updateLahan') is-invalid @enderror" step="0.01" min="0" placeholder="cth: 20" value="{{ old('lebar') }}">
                    @error('lebar','updateLahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Panjang Lahan (m)</label>
                    <input type="number" id="edit-panjang" name="panjang" class="form-control @error('panjang','updateLahan') is-invalid @enderror" step="0.01" min="0" placeholder="cth: 30" value="{{ old('panjang') }}">
                    @error('panjang','updateLahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Keterangan</label>
                    <textarea id="edit-keterangan" name="keterangan" class="form-control @error('keterangan','updateLahan') is-invalid @enderror" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan','updateLahan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('m-lahan-edit')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
window.lahanBaseUrl = "{{ url('/lahan') }}";
window.hasCreateLahanError = {{ ($errors->has('nama_lahan') || $errors->has('lokasi')) ? 'true' : 'false' }};
window.hasUpdateLahanError = {{ $errors->updateLahan->any() ? 'true' : 'false' }};
</script>
<script src="{{ asset('js/pages/beranda.js') }}"></script>
@endsection
