
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Registrasi</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1>Form Registrasi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/registrasi') }}" method="post">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nomor Pendaftaran</label>
            <input type="text" name="nomorPendaftaran" value="{{ old('nomorPendaftaran') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="namaLengkap" value="{{ old('namaLengkap') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenisKelamin" class="form-select" required>
                <option value="">Pilih...</option>
                <option value="Laki-laki" {{ old('jenisKelamin')=='Laki-laki' ? 'selected':'' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenisKelamin')=='Perempuan' ? 'selected':'' }}>Perempuan</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempatLahir" value="{{ old('tempatLahir') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggalLahir" value="{{ old('tanggalLahir') }}" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Agama</label>
            <input type="text" name="agama" value="{{ old('agama') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="noHP" value="{{ old('noHP') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Asal Sekolah</label>
            <input type="text" name="asalSekolah" value="{{ old('asalSekolah') }}" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select" required>
                        <option value="">Pilih jurusan...</option>
                        <!-- SMA -->
                        <option value="Ilmu Pengetahuan Sosial (IPS)" {{ old('jurusan')=='Ilmu Pengetahuan Sosial (IPS)' ? 'selected' : '' }}>Ilmu Pengetahuan Sosial (IPS)  </option>
                        <option value="Ilmu Pengetahuan Alam (IPA)" {{ old('jurusan')=='Ilmu Pengetahuan Alam (IPA)' ? 'selected' : '' }}>Ilmu Pengetahuan Alam (IPA)  </option>
                        <option value="Bahasa" {{ old('jurusan')=='Bahasa' ? 'selected' : '' }}>Bahasa</option>

                        <!-- SMK Teknologi & Rekayasa -->
                        <option value="Teknik Komputer dan Jaringan (TKJ)" {{ old('jurusan')=='Teknik Komputer dan Jaringan (TKJ)' ? 'selected' : '' }}>Teknik Komputer dan Jaringan (TKJ)</option>
                        <option value="Teknik Mesin" {{ old('jurusan')=='Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                        <option value="Teknik Sipil" {{ old('jurusan')=='Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                        <option value="Teknik Kendaraan Ringan (TKR)" {{ old('jurusan')=='Teknik Kendaraan Ringan (TKR)' ? 'selected' : '' }}>Teknik Kendaraan Ringan (TKR)</option>
                        <option value="Teknik Elektro" {{ old('jurusan')=='Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                        <!-- SMK Bisnis & Manajemen -->
                        <option value="Akuntansi" {{ old('jurusan')=='Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                        <option value="Manajemen Perkantoran" {{ old('jurusan')=='Manajemen Perkantoran' ? 'selected' : '' }}>Manajemen Perkantoran</option>
                        <option value="Perbankan" {{ old('jurusan')=='Perbankan' ? 'selected' : '' }}>Perbankan</option>

                        <!-- SMK Pariwisata -->
                        <option value="Tata Boga" {{ old('jurusan')=='Tata Boga' ? 'selected' : '' }}>Tata Boga</option>
                        <option value="Perhotelan" {{ old('jurusan')=='Perhotelan' ? 'selected' : '' }}>Perhotelan</option>
                        <option value="Usaha Perjalanan Wisata (UPW)" {{ old('jurusan')=='Usaha Perjalanan Wisata (UPW)' ? 'selected' : '' }}>Usaha Perjalanan Wisata (UPW)</option>


                        <!-- SMK Seni -->
                        <option value="Seni Musik" {{ old('jurusan')=='Seni Musik' ? 'selected' : '' }}>Seni Musik</option>
                        <option value="Seni Tari" {{ old('jurusan')=='Seni Tari' ? 'selected' : '' }}>Seni Tari</option>
                        <!-- Lainnya -->
                        <option value="Lainnya" {{ old('jurusan')=='Lainnya' ? 'selected' : '' }}>Lainnya</option>

                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tahun Lulus</label>
                <select name="tahunLulus" class="form-select" required>
                    <option value="">Pilih tahun lulus</option>
                      @php
                        $tahunSekarang = date('Y');
                        $tahunMulai = $tahunSekarang - 5;
                      @endphp
                      @for($y = $tahunSekarang; $y >= $tahunMulai; $y--)
                          <option value="{{ $y }}" {{ (string) old('tahunLulus') === (string) $y ? 'selected' : '' }}>{{ $y }}</option>
                      @endfor
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Daftar</label>
            <input type="date" name="tanggalDaftar" value="{{ old('tanggalDaftar', now()->toDateString()) }}" class="form-control">
            <div class="form-text">Biarkan kosong untuk otomatis diisi hari ini.</div>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Registrasi</button>
    </form>
</div>
</body>
</html>
