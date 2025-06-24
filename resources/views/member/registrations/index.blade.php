{{-- resources/views/member/registrations/index.blade.php --}}
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
                        <td>
                            @php
                                $statusClass = 'bg-label-secondary';
                                if ($registration->status->name == 'Menunggu Pembayaran') $statusClass = 'bg-label-warning';
                                if ($registration->status->name == 'Pembayaran Diterima') $statusClass = 'bg-label-success';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $registration->status->name }}</span>
                        </td>
                        <td>
                            @if ($registration->status->name == 'Menunggu Pembayaran')
                                <a href="{{ route('member.registrations.payment', $registration) }}" class="btn btn-sm btn-primary">Lakukan Pembayaran</a>
                            @elseif ($registration->status->name == 'Pembayaran Diterima')
                                {{-- PERUBAHAN 1: Tombol ini sekarang memicu Modal --}}
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#qrModal-{{ $registration->id }}">
                                    Lihat Tiket
                                </button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    {{-- PERUBAHAN 2: Tambahkan struktur Modal untuk setiap pendaftaran --}}
                    @if ($registration->status->name == 'Pembayaran Diterima')
                    <div class="modal fade qr-modal" id="qrModal-{{ $registration->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Tiket QR Code</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p>Tunjukkan QR Code ini kepada panitia saat registrasi ulang.</p>
                                    
                                    {{-- Kontainer untuk QR Code, dengan data yang akan di-encode --}}
                                    <div class="qr-code-container d-flex justify-content-center"
                                         data-qr-content="REG-{{ $registration->user_id }}-{{ $registration->event_session_id }}">
                                        {{-- QR Code akan dibuat di sini oleh JavaScript --}}
                                    </div>
                                    
                                    <p class="mt-3 mb-0"><strong>{{ $registration->user->name }}</strong></p>
                                    <p class="text-muted">{{ $registration->eventSession->title }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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

@push('scripts')
{{-- PERUBAHAN 3: Tambahkan JavaScript untuk membuat QR Code --}}
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pilih semua modal yang memiliki class 'qr-modal'
        const qrModals = document.querySelectorAll('.qr-modal');

        qrModals.forEach(modal => {
            // Tambahkan event listener yang akan dijalankan TEPAT SEBELUM modal ditampilkan
            modal.addEventListener('show.bs.modal', function (event) {
                const qrContainer = this.querySelector('.qr-code-container');
                
                // Cek apakah QR code sudah pernah dibuat untuk modal ini
                if (qrContainer.innerHTML.trim() === '') {
                    const content = qrContainer.getAttribute('data-qr-content');
                    if (content) {
                        // Buat QR Code baru
                        new QRCode(qrContainer, {
                            text: content,
                            width: 256,
                            height: 256,
                        });
                    }
                }
            });
        });
    });
</script>
@endpush
