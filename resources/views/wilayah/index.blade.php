<h2>Wilayah Indonesia</h2>

<select id="provinsi">
    <option value="">Pilih Provinsi</option>
    @foreach($provinsi as $p)
        <option value="{{ $p->id }}">{{ $p->name ?? $p->nama_provinsi ?? $p->province_name }}</option>
    @endforeach
</select>

<select id="kota">
    <option value="">Pilih Kota</option>
</select>

<select id="kecamatan">
    <option value="">Pilih Kecamatan</option>
</select>

<select id="kelurahan">
    <option value="">Pilih Kelurahan</option>
</select>

<input type="text" id="wilayahTerpilih" readonly placeholder="Wilayah terpilih" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#provinsi').on('change', function() {
        const provinsiId = $(this).val();

        resetSelect('#kota', 'Pilih Kota');
        resetSelect('#kecamatan', 'Pilih Kecamatan');
        resetSelect('#kelurahan', 'Pilih Kelurahan');

        if (provinsiId) {
            loadKota(provinsiId);
        }

        updateWilayahTerpilih();
    });

    $('#kota').on('change', function() {
        const kotaId = $(this).val();

        resetSelect('#kecamatan', 'Pilih Kecamatan');
        resetSelect('#kelurahan', 'Pilih Kelurahan');

        if (kotaId) {
            loadKecamatan(kotaId);
        }

        updateWilayahTerpilih();
    });

    $('#kecamatan').on('change', function() {
        const kecamatanId = $(this).val();

        resetSelect('#kelurahan', 'Pilih Kelurahan');

        if (kecamatanId) {
            loadKelurahan(kecamatanId);
        }

        updateWilayahTerpilih();
    });

    $('#kelurahan').on('change', updateWilayahTerpilih);
});

function loadKota(provinsiId) {
    $.get('/get-kota/' + provinsiId)
        .done(function(data) {
            fillSelect('#kota', data, 'id', 'name', 'Pilih Kota');
        })
        .fail(function() {
            resetSelect('#kota', 'Pilih Kota');
        });
}

function loadKecamatan(kotaId) {
    $.get('/get-kecamatan/' + kotaId)
        .done(function(data) {
            fillSelect('#kecamatan', data, 'id', 'name', 'Pilih Kecamatan');
        })
        .fail(function() {
            resetSelect('#kecamatan', 'Pilih Kecamatan');
        });
}

function loadKelurahan(kecamatanId) {
    $.get('/get-kelurahan/' + kecamatanId)
        .done(function(data) {
            fillSelect('#kelurahan', data, 'id', 'name', 'Pilih Kelurahan');
        })
        .fail(function() {
            resetSelect('#kelurahan', 'Pilih Kelurahan');
        });
}

function fillSelect(selector, items, valueField, textField, placeholder) {
    const select = $(selector);
    select.empty();
    select.append('<option value="">' + placeholder + '</option>');

    if (items && items.length) {
        items.forEach(function(item) {
            const value = item[valueField] || item.id || item.kode || '';
            const text = item[textField] || item.name || item.nama || '';
            select.append('<option value="' + value + '">' + text + '</option>');
        });
    }
}

function resetSelect(selector, placeholder) {
    $(selector).empty().append('<option value="">' + placeholder + '</option>');
}

function updateWilayahTerpilih() {
    const provinsi = $('#provinsi option:selected').text();
    const kota = $('#kota option:selected').text();
    const kecamatan = $('#kecamatan option:selected').text();
    const kelurahan = $('#kelurahan option:selected').text();

    const chunks = [];
    if (provinsi && provinsi !== 'Pilih Provinsi') chunks.push(provinsi);
    if (kota && kota !== 'Pilih Kota') chunks.push(kota);
    if (kecamatan && kecamatan !== 'Pilih Kecamatan') chunks.push(kecamatan);
    if (kelurahan && kelurahan !== 'Pilih Kelurahan') chunks.push(kelurahan);

    $('#wilayahTerpilih').val(chunks.join(' -> '));
}
</script>