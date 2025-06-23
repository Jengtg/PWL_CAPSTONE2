@extends('layouts.master')
@section('title', 'Scan Kehadiran')

@section('web-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('committee.attendance.index') }}">Kelola Kehadiran</a> /
        </span> 
        Scan QR Code untuk Sesi: {{ $session->title }}
    </h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <div id="qr-reader" style="width: 100%;"></div>
                    <div id="qr-reader-results" class="mt-3"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
             <div class="card">
                <div class="card-header"><h5 class="mb-0">Hasil Scan Terakhir</h5></div>
                <div class="card-body" id="scan-result-info">
                    <p class="text-muted">Arahkan kamera ke QR Code peserta untuk mencatat kehadiran.</p>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Kita akan menggunakan library html5-qrcode --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan sejenak scanner agar tidak scan berulang kali
        html5QrcodeScanner.pause();

        // Tampilkan hasil di console untuk debug
        console.log(`Code matched = ${decodedText}`, decodedResult);

        let resultDiv = document.getElementById('scan-result-info');
        resultDiv.innerHTML = `<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div><p>Memproses: ${decodedText}</p></div>`;

        // Kirim data ke backend menggunakan fetch API
        fetch("{{ route('committee.attendance.process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qr_code: decodedText,
                session_id: {{ $session->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            let alertClass = data.success ? 'alert-success' : 'alert-danger';
            resultDiv.innerHTML = `<div class="alert ${alertClass}">${data.message}</div>`;
            // Lanjutkan scan setelah beberapa detik
            setTimeout(() => { html5QrcodeScanner.resume(); }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memproses.</div>`;
            setTimeout(() => { html5QrcodeScanner.resume(); }, 3000);
        });
    }

    function onScanFailure(error) {
        // Abaikan error jika QR code tidak ditemukan, karena ini terjadi terus menerus
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { fps: 10, qrbox: {width: 250, height: 250} }, 
        false // verbose
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush
