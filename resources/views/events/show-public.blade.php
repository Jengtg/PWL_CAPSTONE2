{{-- resources/views/events/show-public.blade.php --}}
@extends('layouts.master')

@section('title', $event->title)

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('events.guest.index') }}" class="text-muted fw-light">Event /</a> {{ $event->title }}
    </h4>

    <div class="row">
        <!-- Kolom Kiri: Poster dan Detail Utama -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if($event->poster_kegiatan)
                        <img class="img-fluid rounded mb-4" 
                             src="{{ asset('storage/' . $event->poster_kegiatan) }}" 
                             alt="Poster {{ $event->title }}">
                    @endif
                    
                    <h3 class="mb-3">{{ $event->title }}</h3>

                    <div class="d-flex flex-wrap mb-4">
                        @if($event->eventCategory)
                            <div class="me-4 mb-2"><span class="badge bg-label-primary">{{ $event->eventCategory->name }}</span></div>
                        @endif
                        <div class="me-4 mb-2"><i class="bx bx-calendar me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d F Y') }}</div>
                        <div class="mb-2"><i class="bx bx-time-five me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('H:i') }} WIB</div>
                    </div>

                    <h5 class="mt-4">Deskripsi Event</h5>
                    <p>{!! nl2br(e($event->description)) !!}</p> {{-- nl2br untuk mengubah baris baru menjadi tag <br> --}}

                    <h5 class="mt-4">Narasumber</h5>
                    <p><i class="bx bx-user-voice me-1"></i> {{ $event->narasumber }}</p>

                    <h5 class="mt-4">Lokasi</h5>
                    <p><i class="bx bx-map me-1"></i> {{ $event->lokasi }}</p>

                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Info Registrasi dan Tombol Aksi -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registrasi</h5>
                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya</span>
                        @if(isset($event->biaya_registrasi) && $event->biaya_registrasi > 0)
                            <span class="fw-semibold">Rp {{ number_format($event->biaya_registrasi, 0, ',', '.') }}</span>
                        @else
                            <span class="fw-semibold text-success">Gratis</span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Peserta</span>
                        <span class="fw-semibold">{{ $event->eventRegistrations->count() }} / {{ $event->jumlah_maksimal_peserta }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Sisa Kuota</span>
                        @php
                            $sisaKuota = $event->jumlah_maksimal_peserta - $event->eventRegistrations->count();
                        @endphp
                        <span class="fw-semibold">{{ $sisaKuota > 0 ? $sisaKuota : 'Penuh' }}</span>
                    </div>

                    <div class="d-grid gap-2 mx-auto mt-4">
                        @php
                            $isFull = $sisaKuota <= 0;
                        @endphp

                        @guest
                            <a href="{{ route('login') }}?redirect_to_event={{ $event->id }}" class="btn btn-primary">Login untuk Daftar</a>
                        @endguest

                        @auth
                            @if(auth()->user()->role == 'member')
                                @php
                                    $isRegistered = auth()->user()->eventRegistrations()->where('event_id', $event->id)->exists();
                                @endphp
                                
                                @if($isRegistered)
                                    <button class="btn btn-success" disabled><i class="bx bx-check-circle me-1"></i> Sudah Terdaftar</button>
                                @elseif($isFull)
                                    <button class="btn btn-secondary" disabled>Kuota Penuh</button>
                                @else
                                    <form action="{{ route('events.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Daftar Event Ini</button>
                                    </form>
                                @endif
                            @else
                                <button class="btn btn-secondary" disabled>Login sebagai Member</button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
