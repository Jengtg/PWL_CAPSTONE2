{{-- resources/views/committee/events/create.blade.php --}}
@extends('layouts.master')

@section('title', 'Tambah Event Baru - Panitia')

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kelola Event /</span> Tambah Event Baru
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulir Event Baru</h5>
                    <small class="text-muted float-end">Mohon isi semua field yang diperlukan</small>
                </div>
                <div class="card-body">
                    {{-- Tampilkan error validasi global jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('committee.events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="title">Nama Event</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Contoh: Seminar Nasional AI 2025" value="{{ old('title') }}" required />
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Deskripsi Event</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Jelaskan detail mengenai event ini..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="event_category_id" class="form-label">Kategori Event</label>
                                <select id="event_category_id" class="form-select @error('event_category_id') is-invalid @enderror" name="event_category_id" required>
                                    <option value="">Pilih Kategori...</option>
                                    @if(isset($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('event_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('event_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="narasumber">Narasumber</label>
                                <input type="text" class="form-control @error('narasumber') is-invalid @enderror" id="narasumber" name="narasumber" placeholder="Contoh: Prof. Dr. Budi, S.Kom., M.Kom." value="{{ old('narasumber') }}" required />
                                @error('narasumber')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="start_date">Tanggal & Waktu Mulai</label>
                                <input class="form-control @error('start_date') is-invalid @enderror" type="datetime-local" value="{{ old('start_date') }}" id="start_date" name="start_date" required />
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="end_date">Tanggal & Waktu Selesai</label>
                                <input class="form-control @error('end_date') is-invalid @enderror" type="datetime-local" value="{{ old('end_date') }}" id="end_date" name="end_date" required />
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi Event</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" placeholder="Contoh: Auditorium Gedung A, Universitas XYZ" value="{{ old('lokasi') }}" required />
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="biaya_registrasi">Biaya Registrasi (Rp)</label>
                                <input type="number" class="form-control @error('biaya_registrasi') is-invalid @enderror" id="biaya_registrasi" name="biaya_registrasi" placeholder="0 untuk gratis" value="{{ old('biaya_registrasi', 0) }}" required min="0" step="1000" />
                                @error('biaya_registrasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jumlah_maksimal_peserta">Jumlah Maksimal Peserta</label>
                                <input type="number" class="form-control @error('jumlah_maksimal_peserta') is-invalid @enderror" id="jumlah_maksimal_peserta" name="jumlah_maksimal_peserta" placeholder="Contoh: 100" value="{{ old('jumlah_maksimal_peserta') }}" required min="1" />
                                @error('jumlah_maksimal_peserta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="poster_kegiatan" class="form-label">Poster Kegiatan</label>
                            <input class="form-control @error('poster_kegiatan') is-invalid @enderror" type="file" id="poster_kegiatan" name="poster_kegiatan" accept="image/png, image/jpeg, image/gif">
                            <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal 2MB.</div>
                            @error('poster_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan Event</button>
                            <a href="{{ route('committee.events.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
