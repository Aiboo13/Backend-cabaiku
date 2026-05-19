@extends('layouts.app')
@section('title','Riwayat Deteksi')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/riwayat.css') }}">
@endsection
@section('content')
<div class="page-header"><h1>🗂️ Riwayat Deteksi</h1><p>Lihat semua hasil deteksi penyakit tanaman cabai Anda</p></div>
<div class="stat-row">
    <div class="sb"><div class="sb-num">{{ $totalDeteksi }}</div><div class="sb-label">Total Deteksi</div></div>
    <div class="sb"><div class="sb-num g"><i class="fa-solid fa-circle-check" style="font-size:1.2rem;"></i> {{ $tanamanSehat }}</div><div class="sb-label">Tanaman Sehat</div></div>
    <div class="sb"><div class="sb-num r"><i class="fa-solid fa-circle-exclamation" style="font-size:1.2rem;"></i> {{ $terdeteksiPenyakit }}</div><div class="sb-label">Terdeteksi Penyakit</div></div>
</div>
@if($riwayats->isEmpty())
<div class="empty"><div style="font-size:3rem;margin-bottom:16px;opacity:.4;">📷</div><h3 style="font-weight:700;margin-bottom:8px;">Belum Ada Riwayat</h3><p style="color:var(--text-muted);margin-bottom:20px;">Anda belum melakukan deteksi penyakit.</p><a href="{{ route('deteksi') }}" class="btn btn-primary"><i class="fa-solid fa-camera"></i> Mulai Deteksi</a></div>
@else
<div class="rlist">
    @foreach($riwayats as $r)
    @php $isS=$r->hasil==='Sehat'; $isB=$r->tingkat_keparahan==='Berat'; $ic=$isS?'sehat':($isB?'berat':'sakit'); $em=$isS?'✅':($isB?'🚨':'⚠️'); @endphp
    <div class="ritem">
        <div class="ricon {{ $ic }}">{{ $em }}</div>
        <div class="rcontent">
            <div class="rhasil">{{ $r->hasil }}</div>
            <div class="rmeta">
                <span class="badge badge-{{ strtolower($r->tingkat_keparahan) }}">{{ $r->tingkat_keparahan }}</span>
                <div class="rmeta-item"><i class="fa-solid fa-bullseye"></i> {{ $r->akurasi }}%</div>
                <div class="rmeta-item"><i class="fa-regular fa-calendar"></i> {{ $r->created_at->translatedFormat('d M Y') }}</div>
                <div class="rmeta-item"><i class="fa-regular fa-clock"></i> {{ $r->created_at->format('H:i') }}</div>
                @if($r->lahan)<div class="rmeta-item"><i class="fa-solid fa-location-dot"></i> {{ $r->lahan->nama_lahan }}</div>@endif
            </div>
        </div>
        <form method="POST" action="{{ route('riwayat.destroy',$r->id) }}" onsubmit="return confirm('Hapus riwayat ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="del-btn"><i class="fa-solid fa-trash"></i></button>
        </form>
    </div>
    @endforeach
</div>
@if($riwayats->hasPages())
<div style="display:flex;justify-content:center;gap:6px;margin-bottom:32px;">
    @if(!$riwayats->onFirstPage())<a href="{{ $riwayats->previousPageUrl() }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-left"></i></a>@endif
    <span style="display:flex;align-items:center;font-size:.875rem;color:var(--text-muted);padding:0 12px;">Hal {{ $riwayats->currentPage() }} / {{ $riwayats->lastPage() }}</span>
    @if($riwayats->hasMorePages())<a href="{{ $riwayats->nextPageUrl() }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-right"></i></a>@endif
</div>
@endif
@endif
@endsection
