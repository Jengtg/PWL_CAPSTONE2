@extends('layouts.master')
@section('title', 'Kelola Kehadiran')

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Panitia /</span> Kelola Kehadiran</h4>
    <div class="card">
        <h5 class="card-header">Pilih Sesi untuk Absensi</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Judul Sesi</th><th>Event Induk</th><th>Jadwal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $session)
                    <tr>
                        <td><strong>{{ $session->title }}</strong></td>
                        <td>{{ $session->event->title }}</td>
                        <td>{{ $session->start_datetime->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('committee.attendance.scan', $session->id) }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-qr-scan me-1"></i> Buka Scanner
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Tidak ada sesi yang dijadwalkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 mx-4">{{ $sessions->links() }}</div>
    </div>
</div>
@endsection