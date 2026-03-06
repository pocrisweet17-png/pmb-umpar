<h1>Tagihan Pendaftaran</h1>
<p>Nama: {{ $reg->nama_lengkap }}</p>
<p>Prodi: {{ $reg->prodi_kode }} - Gelombang {{ $reg->gelombang }}</p>

<h3>Biaya Pendaftaran: Rp {{ number_format($biaya->biaya_pendaftaran) }}</h3>
@if($reg->sudahBayarPendaftaran())
    <p>Lunas</p>
@else
    <a href="{{ route('bayar', [$reg->idRegistrasi, 'pendaftaran']) }}" class="btn btn-success">Bayar Sekarang</a>
@endif

<h3>UKT Semester 1: Rp {{ number_format($biaya->ukt_semester_1) }}</h3>
@if($reg->sudahBayarUKT())
    <p>Lunas - Selamat! Anda bisa cetak kartu ujian</p>
@else
    <a href="{{ route('bayar', [$reg->idRegistrasi, 'ukt']) }}" class="btn btn-primary">Bayar UKT</a>
@endif
