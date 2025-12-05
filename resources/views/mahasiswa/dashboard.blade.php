@extends('layouts.app')

@section('content')

@if(!auth()->user()->is_prodi_selected)
    <script>
        window.onload = function() {
            const modal = new bootstrap.Modal(document.getElementById('modalPilihProdi'));
            modal.show();
        }
    </script>
@endif

<div class="container mt-4">
    <h3>Dashboard Mahasiswa</h3>
    <p>Selamat datang, {{ auth()->user()->namaLengkap ?? auth()->user()->username }}</p>
</div>



<div class="modal fade" id="modalPilihProdi" tabindex="-1" aria-labelledby="prodiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="prodiLabel">Pilih Program Studi</h5>
            </div>

            <div class="modal-body">
                <p class="mb-3">Silakan pilih <b>2 Program Studi</b> sesuai minat Anda.</p>

                {{-- FORM --}}
                <form action="{{ route('prodi.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fakultas</label>
                            <select id="fakultas">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach ($fakultas as $f)
                                    <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Studi (Pilihan 1)</label>
                            <select name="prodi1" id="prodi1" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                {{-- Akan diisi via AJAX --}}
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Program Studi (Pilihan 2)</label>
                            <select name="prodi2" id="prodi2" class="form-select" required>
                                <option value="">-- Pilih Prodi --</option>
                                {{-- Akan diisi via AJAX --}}
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100">Simpan Pilihan Prodi</button>
                </form>
            </div>

        </div>
    </div>
</div>


@endsection


@section('scripts')
<script src="{{ asset('js/pilih-prodi.js') }}" defer></script>
<script>
    document.getElementById('fakultas').addEventListener('change', function() {
        let fakultas = this.value;

        fetch(`/get-prodi/${fakultas}`)
            .then(response => response.json())
            .then(data => {
                let prodi1 = document.getElementById('prodi1');
                let prodi2 = document.getElementById('prodi2');

                prodi1.innerHTML = '<option value="">-- Pilih Prodi --</option>';
                prodi2.innerHTML = '<option value="">-- Pilih Prodi --</option>';

                data.forEach(p => {
                    let opt = `<option value="${p.kodeProdi}">${p.namaProdi} (${p.jenjang})</option>`;
                    prodi1.innerHTML += opt;
                    prodi2.innerHTML += opt;
                });
            });
    });
</script>
@endsection
