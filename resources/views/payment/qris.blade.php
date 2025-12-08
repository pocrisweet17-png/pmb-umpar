@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Pembayaran via QRIS</h3>

    <p class="mt-3">Silakan scan QRIS berikut:</p>

    <img src="/img/qris.png" class="img-fluid mb-3" width="280">

    <p class="fw-bold fs-5">
        Total: Rp {{ number_format($jumlah) }}
    </p>

    <form action="{{ route('qris.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="fw-bold">Upload Bukti Pembayaran</label>
        <input type="file" name="bukti_bayar" class="form-control" required>

        <input type="hidden" name="jumlah" value="{{ $jumlah }}">

        <button class="btn btn-success mt-3 w-100">Kirim Bukti</button>
    </form>

</div>
@endsection
