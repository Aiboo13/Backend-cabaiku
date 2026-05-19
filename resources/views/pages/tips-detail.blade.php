@extends('layouts.app')
@section('title', $artikel->judul)
@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/tips-detail.css') }}">
@endsection
@section('content')
<div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
    <a href="{{ route('tips') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <span class="badge badge-primary">{{ $artikel->kategori }}</span>
</div>
<img src="{{ $artikel->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=800' }}" alt="{{ $artikel->judul }}" class="art-hero">
<div class="art-meta">
    <div class="art-meta-item"><i class="fa-solid fa-tag"></i> {{ $artikel->kategori }}</div>
    <div class="art-meta-item"><i class="fa-regular fa-clock"></i> {{ $artikel->waktu_baca }} menit baca</div>
    <div class="art-meta-item"><i class="fa-regular fa-user"></i> {{ $artikel->penulis }}</div>
    <div class="art-meta-item"><i class="fa-regular fa-calendar"></i> {{ $artikel->formatted_date }}</div>
</div>
<h1 class="art-title">{{ $artikel->judul }}</h1>
@if($artikel->ringkasan)<div class="art-summary">{{ $artikel->ringkasan }}</div>@endif
<div class="art-content">{!! $artikel->konten !!}</div>
@if($related->isNotEmpty())
<div class="rel-sec">
    <div class="rel-title">📌 Artikel Terkait</div>
    <div class="rel-grid">
        @foreach($related as $r)
        <a href="{{ route('tips.show',$r->id) }}" class="rel-card">
            <img src="{{ $r->gambar ?? 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=400' }}" alt="{{ $r->judul }}" class="rel-img">
            <div class="rel-body"><div class="rel-kat">{{ $r->kategori }}</div><div class="rel-judul">{{ $r->judul }}</div></div>
        </a>
        @endforeach
    </div>
</div>
@endif
@endsection
