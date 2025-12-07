@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Pembayaran Biaya Pendaftaran</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Data Pendaftar</h5>
            
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>NIM / Email</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Pilihan Prodi</th>
                    <td>
                        1. {{ $user->pilihan_1 }} <br>
                        2. {{ $user->pilihan_2 }}
                    </td>
                </tr>

                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        @if($user->is_bayar_pendaftaran)
                            <span class="badge bg-success">Sudah Bayar</span>
                        @else
                            <span class="badge bg-danger">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
            </table>

            <hr>

            <h4>Biaya Pendaftaran</h4>
            <p class="fs-4 fw-bold">
                Rp {{ number_format($biaya_pendaftaran) }}
            </p>

            @if($user->is_bayar_pendaftaran)
                <div class="alert alert-success">
                    Anda sudah melakukan pembayaran biaya pendaftaran.
                </div>
            @else
                <form action="{{ route('bayar.store') }}" method="POST">
                    @csrf

                    <button class="btn btn-primary btn-lg w-100">
                        Bayar Sekarang
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection
