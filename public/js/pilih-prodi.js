// public/js/pilih-prodi.js
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('modalPilihProdi');
    if (!modal) return; // kalau modal gak ada, stop

    modal.classList.remove('hidden');

    const fakultasSelect = document.getElementById('selectFakultas');
    const prodi1 = document.getElementById('selectProdi1');
    const prodi2 = document.getElementById('selectProdi2');

    fakultasSelect.addEventListener('change', function () {
        const fakultas = this.value;
        console.log("Fakultas dipilih:", fakultas);

        if (!fakultas) {
            prodi1.innerHTML = '<option value="">-- Pilih Prodi --</option>';
            prodi2.innerHTML = '<option value="">-- Pilih Prodi --</option>';
            return;
        }

        fetch(`/api/prodi-by-fakultas?fakultas=${encodeURIComponent(fakultas)}`)
            .then(res => {
                if (!res.ok) {
                    console.error("HTTP Error:", res.status);
                    throw new Error('Gagal memuat prodi');
                }
                return res.json();
            })
            .then(data => {
                console.log("Data prodi:", data);
                let optionHtml = `<option value="">-- Pilih Prodi --</option>`;
                data.forEach(p => {
                    optionHtml += `<option value="${p.kodeProdi}">${p.namaProdi}</option>`;
                });
                prodi1.innerHTML = optionHtml;
                prodi2.innerHTML = optionHtml;
            })
            .catch(err => {
                console.error(err);
                prodi1.innerHTML = '<option value="">Error loading</option>';
                prodi2.innerHTML = '<option value="">Error loading</option>';
            });
    });
});