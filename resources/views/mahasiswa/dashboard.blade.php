@extends('layouts.app')

@section('content')

@php
    $user = request()->user();
@endphp

<div class="container mt-4">
    <h3 class="fw-bold">Dashboard Mahasiswa</h3>
    <p>Selamat datang, {{ $user->namaLengkap ?? $user->username }}</p>

    <div class="card p-4 shadow mt-4">
        <h5 class="fw-bold mb-3">Progres Pendaftaran Mahasiswa Baru</h5>

        <ul class="list-group">

            {{-- 1. PILIH PRODI --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>1. Pilih Program Studi</span>

                @if(!$user->is_prodi_selected)
                    <a href="#" class="btn btn-primary btn-sm" onclick="showModalProdi()">Pilih</a>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </li>

            {{-- 2. BAYAR PENDAFTARAN --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>2. Bayar Pendaftaran</span>

                @if(!$user->is_prodi_selected)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Pilih Prodi</button>
                @elseif(!$user->is_bayar_pendaftaran)
                    <a href="{{ route('tagihan') }}" class="btn btn-primary btn-sm">Bayar</a>
                @else
                    <span class="badge bg-success">Lunas</span>
                @endif
            </li>

            {{-- 3. LENGKAPI DATA DIRI --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>3. Lengkapi Data</span>

                @if(!$user->is_bayar_pendaftaran)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Pembayaran</button>
                @elseif(!$user->is_data_completed)
                    <a href="{{ route('pendaftaran.form') }}" class="btn btn-primary btn-sm">Isi Data</a>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </li>

            {{-- 4. UPLOAD DOKUMEN --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>4. Upload Dokumen</span>

                @if(!$user->is_data_completed)
                    <button class="btn btn-secondary btn-sm" disabled>Lengkapi Data Dulu</button>
                @elseif(!$user->is_dokumen_uploaded)
                    <a href="{{ route('dokumen.form') }}" class="btn btn-primary btn-sm">Upload</a>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </li>

            {{-- 5. TES --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>5. Tes Offline / Online</span>

                @if(!$user->is_dokumen_uploaded)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Dokumen</button>
                @elseif(!$user->is_tes_selesai)
                    <a href="#" class="btn btn-warning btn-sm">Menunggu Jadwal</a>
                @else
                    <span class="badge bg-success">Lulus Tes</span>
                @endif
            </li>

            {{-- 6. WAWANCARA --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>6. Wawancara</span>

                @if(!$user->is_tes_selesai)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Tes</button>
                @elseif(!$user->is_wawancara_selesai)
                    <a href="#" class="btn btn-warning btn-sm">Menunggu Wawancara</a>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </li>

            {{-- 7. DAFTAR ULANG --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>7. Daftar Ulang</span>

                @if(!$user->is_wawancara_selesai)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Wawancara</button>
                @elseif(!$user->is_daftar_ulang)
                    <a href="#" class="btn btn-primary btn-sm">Daftar Ulang</a>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
            </li>

            {{-- 8. BAYAR UKT --}}
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>8. Pembayaran UKT Semester 1</span>

                @if(!$user->is_daftar_ulang)
                    <button class="btn btn-secondary btn-sm" disabled>Menunggu Daftar Ulang</button>
                @elseif(!$user->is_ukt_paid)
                    <a href="{{ route('bayar', 'ukt') }}" class="btn btn-primary btn-sm">Bayar UKT</a>
                @else
                    <span class="badge bg-success">Lunas</span>
                @endif
            </li>

        </ul>
    </div>
</div>

{{-- Modal Pilih Prodi --}}
@if(!$user->is_prodi_selected)
    @include('mahasiswa.pilih-prodi-modal')
@endif

@endsection

@section('scripts')
<script>
function showModalProdi() {
    new bootstrap.Modal(document.getElementById('modalPilihProdi')).show();
}
</script>
@endsection
