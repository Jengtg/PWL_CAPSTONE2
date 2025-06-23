@extends('layouts.master')
@section('title', 'Event Saya')

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Area Member /</span> Pendaftaran Saya</h4>
    <div class="card">
        <h5 class="card-header">Riwayat Pendaftaran</h5>
        <div class="table-responsive text-nowrap">
            @if(session('success'))<div class="alert alert-success mx-4">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger mx-4">{{ session('error') }}</div>@endif
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th><th>Sesi</th><th>Event Induk</th><th>Jadwal Sesi</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($registrations as $index => $registration)
                    <tr>
                        <td>{{ $registrations->firstItem() + $index }}</td>
                        <td><strong>{{ $registration->eventSession->title }}</strong></td>
                        <td>{{ $registration->eventSession->event->title }}</td>
                        <td>{{ $registration->eventSession->start_datetime->format('d M Y, H:i') }}</td>
                        <td><span class="badge bg-label-{{ $registration->status->name == 'Menunggu Pembayaran' ? 'warning' : ($registration->status->name == 'Pembayaran Diterima' ? 'success' : 'secondary') }}">{{ $registration->status->name }}</span></td>
                        <td>
                            @if ($registration->status->name == 'Menunggu Pembayaran')
                                <a href="{{ route('member.registrations.payment', $registration) }}" class="btn btn-sm btn-primary">Lakukan Pembayaran</a>
                            @elseif ($registration->status->name == 'Pembayaran Diterima')
                                <a href="#" class="btn btn-sm btn-info">Lihat Tiket</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4">Anda belum terdaftar di event manapun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 mx-4">{{ $registrations->links() }}</div>
    </div>
</div>
@endsection