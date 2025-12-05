@if(!auth()->user()->is_prodi_selected)
<div id="modalPilihProdi" class="fixed inset-0 ... hidden">
    <div id="modalPilihProdi"
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg">

        <h2 class="text-xl font-bold mb-4 text-center">Pilih 2 Program Studi</h2>

        <form action="{{ route('prodi.store') }}" method="POST">
            @csrf

            <!-- Fakultas -->
            <label class="font-semibold">Pilih Fakultas</label>
            <select id="selectFakultas"
                    class="w-full border rounded-lg p-2 mt-1 mb-3">
                <option value="">-- Pilih Fakultas --</option>
                @foreach($fakultas as $f)
                    <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
                @endforeach
            </select>

            <!-- Prodi 1 -->
            <label class="font-semibold">Pilihan 1</label>
            <select name="pilihan_1" id="selectProdi1"
                    class="w-full border rounded-lg p-2 mt-1 mb-3"></select>

            <!-- Prodi 2 -->
            <label class="font-semibold">Pilihan 2</label>
            <select name="pilihan_2" id="selectProdi2"
                    class="w-full border rounded-lg p-2 mt-1 mb-3"></select>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
                Simpan Pilihan
            </button>
        </form>
    </div>
</div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("modalPilihProdi")?.classList.remove("hidden");
    const fakultasSelect = document.getElementById("selectFakultas");
    fakultasSelect?.addEventListener("change", function () {
        const f = this.value;
        if (!f) return;
        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(f)}`)
            .then(r => r.json())
            .then(d => {
                const opt = d.map(p => `<option value="${p.kodeProdi}">${p.namaProdi}</option>`).join("");
                const html = `<option value="">-- Pilih Prodi --</option>${opt}`;
                document.getElementById("selectProdi1").innerHTML = html;
                document.getElementById("selectProdi2").innerHTML = html;
            });
    });
});
</script>
@endpush
@endif


