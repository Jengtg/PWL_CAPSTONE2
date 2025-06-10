{{-- resources/views/committee/events/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Kelola Event - Panitia')

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Panitia /</span> Kelola Event
    </h4>

    <div class="mb-3">
        <a href="{{ route('committee.events.create') }}" class="btn btn-primary">
            <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Tambah Event Baru
        </a>
    </div>

    <div class="card">
        <h5 class="card-header">Daftar Semua Event</h5>
        <div class="table-responsive text-nowrap">
            {{-- Tampilkan pesan sukses jika ada --}}
            @if(session('success'))
                <div class="alert alert-success mx-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Poster</th>
                        <th>Nama Event</th>
                        <th>Kategori</th>
                        <th>Tanggal Mulai</th>
                        <th>Lokasi</th>
                        <th>Biaya (Rp)</th>
                        <th>Peserta</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($events as $index => $event)
                        <tr>
                            <td>{{ $events->firstItem() + $index }}</td>
                            <td>
                                @if($event->poster_kegiatan)
                                    <img src="{{ asset('storage/' . $event->poster_kegiatan) }}" alt="Poster" class="img-thumbnail" width="100">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                                <strong>{{ Str::limit($event->title, 30) }}</strong>
                            </td>
                            <td>{{ $event->eventCategory->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y, H:i') }}</td>
                            <td>{{ Str::limit($event->lokasi, 25) ?? 'N/A' }}</td>
                            <td>{{ number_format($event->biaya_registrasi, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-label-info">
                                    {{ $event->eventRegistrations->count() }} / {{ $event->jumlah_maksimal_peserta }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    {{-- Tombol Lihat Detail --}}
                                    <a class="btn btn-icon btn-sm btn-info me-2" href="{{ route('committee.events.show', $event->id) }}"><i class="bx bx-show"></i></a>

                                    {{-- Tombol Edit --}}
                                    <a class="btn btn-icon btn-sm btn-warning me-2" href="{{ route('committee.events.edit', $event->id) }}"><i class="bx bx-edit-alt"></i></a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('committee.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 mx-4">
            {{ $events->links() }}
        </div>
    </div>
    </div>
@endsection
