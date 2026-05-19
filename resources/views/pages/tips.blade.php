@extends('layouts.app')
@section('title','Tips & Artikel')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/tips.css') }}">
@endsection
@section('content')
<div class="page-header"><h1>📖 Tips & Artikel</h1><p>Panduan lengkap merawat dan membudidayakan tanaman cabai</p></div>

<form method="GET" action="{{ route('tips') }}" id="filter-form">
    <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" name="q" class="search-inp" id="search-inp" placeholder="Cari artikel, tips, atau panduan..." value="{{ request('q') }}" oninput="toggleClear(this)">
        <button type="button" class="search-clear {{ request('q') ? 'show' : '' }}" id="clear-btn" onclick="clearSearch()"><i class="fa-solid fa-xmark"></i></button>
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
    </div>
</form>

<div class="filter-tags">
    <a href="{{ route('tips', ['q'=>request('q')]) }}" class="ftag {{ !request('kategori') ? 'active' : '' }}">Semua</a>
    @foreach($kategoris as $k)
    <a href="{{ route('tips', ['q'=>request('q'),'kategori'=>$k]) }}" class="ftag {{ request('kategori')==$k ? 'active' : '' }}">{{ $k }}</a>
    @endforeach
</div>

@if(request('q'))<div style="font-size:.83rem;color:var(--text-muted);margin-bottom:16px;">Hasil: <strong style="color:var(--text);">"{{ request('q') }}"</strong> — <strong>{{ $artikels->total() }}</strong> artikel <a href="{{ route('tips') }}" style="color:var(--primary);margin-left:8px;">Hapus filter</a></div>@endif

@if($artikels->isEmpty())
<div class="empty"><div class="empty-icon">📭</div><h3 style="font-weight:700;margin-bottom:8px;">Artikel Tidak Ditemukan</h3><p style="color:var(--text-muted);">Coba kata kunci lain atau hapus filter.</p><a href="{{ route('tips') }}" class="btn btn-primary" style="margin-top:16px;">Lihat Semua</a></div>
@else
<div class="ag">
    @foreach($artikels as $ar)
    <a href="{{ route('tips.show',$ar->id) }}" class="ac">
            <div class="ac-img-wrap">
            <?php $img = $ar->gambar ? (filter_var($ar->gambar, FILTER_VALIDATE_URL) ? $ar->gambar : asset('storage/'.$ar->gambar)) : 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=600'; ?>
            <img src="{{ $img }}" alt="{{ $ar->judul }}" class="ac-img">
            <span class="ac-kat">{{ $ar->kategori }}</span>
        </div>
        <div class="ac-body">
            <div class="ac-meta">
                <div class="ac-meta-item"><i class="fa-regular fa-clock"></i> {{ $ar->waktu_baca }} menit</div>
                <div class="ac-meta-item"><i class="fa-regular fa-user"></i> {{ $ar->penulis }}</div>
            </div>
            <div class="ac-judul">{{ $ar->judul }}</div>
            <div class="ac-ring">{{ $ar->ringkasan }}</div>
            <div class="ac-footer">
                <span class="ac-date">{{ $ar->formatted_date }}</span>
                <span class="ac-more">Baca Selengkapnya →</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@if($artikels->hasPages())
<div style="display:flex;justify-content:center;gap:6px;margin-bottom:32px;">
    @if(!$artikels->onFirstPage())<a href="{{ $artikels->previousPageUrl() }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-left"></i></a>@endif
    <span style="display:flex;align-items:center;font-size:.875rem;color:var(--text-muted);padding:0 12px;">Hal {{ $artikels->currentPage() }} / {{ $artikels->lastPage() }}</span>
    @if($artikels->hasMorePages())<a href="{{ $artikels->nextPageUrl() }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chevron-right"></i></a>@endif
</div>
@endif
@endif
@endsection
@section('scripts')
<script src="{{ asset('js/pages/tips.js') }}"></script>
@endsection
