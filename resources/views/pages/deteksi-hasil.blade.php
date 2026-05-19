{{-- FILE: resources/views/pages/deteksi-hasil.blade.php --}}
@extends('layouts.app')
@section('title','Hasil Deteksi')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/deteksi-hasil.css') }}">
@endsection
@section('content')
@php $isSehat=$deteksi->hasil==='Sehat'; $isBerat=$deteksi->tingkat_keparahan==='Berat'; $hc=$isSehat?'sehat':($isBerat?'berat':'sakit'); $emoji=$isSehat?'✅':($isBerat?'🚨':'⚠️'); @endphp
<div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
    <a href="{{ route('deteksi') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="page-header" style="margin-bottom:0;"><h1>Hasil Deteksi</h1><p>{{ $deteksi->created_at->translatedFormat('d F Y, H:i') }}</p></div>
</div>
@if($deteksi->gambar)
<img src="{{ route('deteksi.image', $deteksi->id) }}" alt="Foto Deteksi" class="hasil-img" onerror="this.style.display='none';document.getElementById('img-fallback').style.display='flex';">
<div id="img-fallback" style="display:none;background:var(--surface3);border-radius:var(--radius);height:140px;align-items:center;justify-content:center;color:var(--text-muted);margin-bottom:20px;"><i class="fa-solid fa-image" style="font-size:2rem;"></i></div>
@else
<div style="background:var(--surface3);border-radius:var(--radius);height:140px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);margin-bottom:20px;"><i class="fa-solid fa-image" style="font-size:2rem;"></i></div>
@endif
<div class="res-header {{ $hc }}">
    <div class="res-icon">{{ $emoji }}</div>
    <div style="flex:1;">
        <div class="res-label" style="color:{{ $isSehat?'#065F46':($isBerat?'#7F1D1D':'#92400E') }}">Hasil Deteksi</div>
        <div class="res-nama {{ $hc }}">{{ $deteksi->hasil }}</div>
        @if($deteksi->penyakit)<div style="font-size:.78rem;color:{{ $isBerat?'#991B1B':'#92400E' }};font-style:italic;margin-bottom:8px;">{{ $deteksi->penyakit }}</div>@endif
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <div class="acc-chip" style="color:{{ $isSehat?'#065F46':($isBerat?'#7F1D1D':'#92400E') }}"><i class="fa-solid fa-bullseye"></i> {{ $deteksi->akurasi }}% Akurasi</div>
            <span class="badge badge-{{ strtolower($deteksi->tingkat_keparahan) }}">{{ $deteksi->tingkat_keparahan }}</span>
        </div>
    </div>
</div>
<div class="info-grid">
    <div class="info-item"><div class="info-label">Lahan</div><div class="info-val">{{ $deteksi->lahan->nama_lahan ?? '-' }}</div></div>
    <div class="info-item"><div class="info-label">Tanggal</div><div class="info-val">{{ $deteksi->created_at->translatedFormat('d M Y') }}</div></div>
    <div class="info-item"><div class="info-label">Waktu</div><div class="info-val">{{ $deteksi->created_at->format('H:i') }} WIB</div></div>
    <div class="info-item"><div class="info-label">Keparahan</div><div class="info-val"><span class="badge badge-{{ strtolower($deteksi->tingkat_keparahan) }}">{{ $deteksi->tingkat_keparahan }}</span></div></div>
</div>
@if($deteksi->catatan)<div class="card" style="margin-bottom:20px;"><div class="card-body"><div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);margin-bottom:6px;">Catatan Anda</div><div style="font-size:.875rem;line-height:1.6;">{{ $deteksi->catatan }}</div></div></div>@endif
<div class="rek-box"><div class="rek-title"><span style="font-size:1.2rem;">💊</span> Rekomendasi Penanganan</div><div class="rek-text">{{ $deteksi->rekomendasi }}</div></div>
<div class="act-row">
    <a href="{{ route('deteksi') }}" class="btn btn-outline"><i class="fa-solid fa-camera"></i> Deteksi Lagi</a>
    <a href="{{ route('riwayat') }}" class="btn btn-secondary"><i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat</a>
</div>
@endsection
