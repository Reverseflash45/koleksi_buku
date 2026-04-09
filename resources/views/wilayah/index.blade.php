@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-map"></i>
        </span> Wilayah Indonesia
    </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Lokasi</h4>
                <p class="card-description"> Silahkan pilih wilayah secara berurutan </p>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select id="provinsi" class="form-control form-select border-primary">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinsi as $p)
                                    <option value="{{ $p->id }}">{{ $p->name ?? $p->nama_provinsi ?? $p->province_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kota">Kota/Kabupaten</label>
                            <select id="kota" class="form-control form-select border-primary">
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select id="kecamatan" class="form-control form-select border-primary">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan/Desa</label>
                            <select id="kelurahan" class="form-control form-select border-primary">
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label>Wilayah Terpilih (Ringkasan)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary text-white">
                                <i class="mdi mdi-pin"></i>
                            </span>
                        </div>
                        <input type="text" id="wilayahTerpilih" class="form-control" readonly placeholder="Detail wilayah akan muncul di sini..." style="background-color: #f2edf3;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// JavaScript kamu tetap sama di sini...
$(document).ready(function() {
    $('#provinsi').on('change', function() {
        const provinsiId = $(this).val();
        resetSelect('#kota', 'Pilih Kota');
        resetSelect('#kecamatan', 'Pilih Kecamatan');
        resetSelect('#kelurahan', 'Pilih Kelurahan');
        if (provinsiId) { loadKota(provinsiId); }
        updateWilayahTerpilih();
    });

    $('#kota').on('change', function() {
        const kotaId = $(this).val();
        resetSelect('#kecamatan', 'Pilih Kecamatan');
        resetSelect('#kelurahan', 'Pilih Kelurahan');
        if (kotaId) { loadKecamatan(kotaId); }
        updateWilayahTerpilih();
    });

    $('#kecamatan').on('change', function() {
        const kecamatanId = $(this).val();
        resetSelect('#kelurahan', 'Pilih Kelurahan');
        if (kecamatanId) { loadKelurahan(kecamatanId); }
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
@endsection