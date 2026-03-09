<div id="modalProdi" class="hidden fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center">
<div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative mx-4" onclick="event.stopPropagation()">

<button onclick="closeModalProdi()" class="absolute top-4 right-4 text-2xl text-gray-400">×</button>

<h2 class="text-xl font-bold mb-4 text-center">Pilih Program Studi</h2>

<form id="formPilihProdi" action="{{ route('prodi.store') }}" method="POST">
@csrf

<select id="selectJenjang" class="w-full mb-4 px-4 py-2 border rounded" required>
    <option value="">-- Pilih Jenjang --</option>
    <option value="S1">S1 (Sarjana)</option>
    <option value="S2">S2 (Magister)</option>
    <option value="S3">S3 (Doktor)</option>
    <option value="Profesi">Profesi</option>
</select>

<div id="blokPilihan1" style="display:none">
    <select id="selectFakultas1" class="w-full mb-3 px-4 py-2 border rounded">
        <option value="">-- Pilih Fakultas --</option>
        @foreach($fakultas as $f)
            <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
        @endforeach
    </select>

    <select id="selectProdi1" class="w-full mb-4 px-4 py-2 border rounded" name="pilihan_1">
        <option value="">-- Pilih Prodi --</option>
    </select>
</div>

<div id="blokPilihan2" style="display:none">
    <select id="selectFakultas2" class="w-full mb-3 px-4 py-2 border rounded">
        <option value="">-- Pilih Fakultas Pilihan 2 --</option>
        @foreach($fakultas as $f)
            <option value="{{ $f->fakultas }}">{{ $f->fakultas }}</option>
        @endforeach
    </select>

    <select id="selectProdi2" class="w-full mb-4 px-4 py-2 border rounded" name="pilihan_2">
        <option value="">-- Pilih Prodi Pilihan 2 --</option>
    </select>
</div>

<div id="errorMessage" class="text-red-600 mb-3 text-sm"></div>

<!-- 🔥 TOMBOL BERSIH -->
<button type="submit" class="w-full py-3 bg-blue-600 text-white rounded">
    Simpan
</button>

</form>
</div>
</div>

<script>

(function () {
    window.onbeforeunload = null;

    window.addEventListener(
        'beforeunload',
        function (e) {
            e.stopImmediatePropagation();
        },
        true
    );
})();

document.addEventListener("DOMContentLoaded", () => {

const jenjang = document.getElementById("selectJenjang");
const f1 = document.getElementById("selectFakultas1");
const f2 = document.getElementById("selectFakultas2");
const p1 = document.getElementById("selectProdi1");
const p2 = document.getElementById("selectProdi2");
const blok1 = document.getElementById("blokPilihan1");
const blok2 = document.getElementById("blokPilihan2");
const err = document.getElementById("errorMessage");
const form = document.getElementById("formPilihProdi");

blok1.style.display = "none";
blok2.style.display = "none";

jenjang.onchange = () => {
    blok1.style.display = jenjang.value ? "block" : "none";
    blok2.style.display = jenjang.value === "S1" ? "block" : "none";

    f1.value = "";
    f2.value = "";
    p1.innerHTML = "<option value=''>-- Pilih Prodi --</option>";
    p2.innerHTML = "<option value=''>-- Pilih Prodi --</option>";
};

function load(fak, target){
    if(!fak || !jenjang.value) return;

    fetch(`/api/prodi-by-fakultas?fakultas=${fak}&jenjang=${jenjang.value}`)
    .then(r=>r.json())
    .then(d=>{
        target.innerHTML =
            `<option value="">-- Pilih Prodi --</option>` +
            d.map(x=>`<option value="${x.kodeProdi}">${x.namaProdi}</option>`).join('');
        if(target === p2) filterProdi2();
    });
}

function filterProdi2(){
    const selected = p1.value;
    Array.from(p2.options).forEach(opt=>{
        if(opt.value === "") return;
        opt.disabled = opt.value === selected;
    });
}

f1.onchange = ()=> load(f1.value, p1);
f2.onchange = ()=> load(f2.value, p2);

p1.onchange = ()=>{
    filterProdi2();
    if(p2.value === p1.value) p2.value = "";
};

form.onsubmit = e => {
    e.preventDefault();
    err.innerText = "";

    if(!jenjang.value){
        err.innerText="Pilih jenjang dulu";
        return;
    }
    if(!p1.value){
        err.innerText="Prodi wajib dipilih";
        return;
    }
    if(jenjang.value==="S1"){
        if(!p2.value){
            err.innerText="Pilihan kedua wajib untuk S1";
            return;
        }
        if(p1.value===p2.value){
            err.innerText="Pilihan tidak boleh sama";
            return;
        }
    }

    // 🔥 HILANGKAN WARNING LEAVE
    window.onbeforeunload = null;

    fetch(form.action,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body:JSON.stringify({
            jenjang: jenjang.value,
            pilihan_1: p1.value,
            pilihan_2: jenjang.value==="S1" ? p2.value : null
        })
    })
    .then(r=>r.json())
    .then(d=>{
        if(d.success){
            location.href = d.redirect;
        } else {
            err.innerText = d.message;
        }
    });
};

});
</script>
