@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-city"></i>
        </span> Data Kota
    </h3>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kota Baru</h4>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" id="kotaInput" class="form-control" placeholder="Masukkan nama kota..." aria-label="Nama Kota">
                        <div class="input-group-append">
                            <button id="btnTambah" class="btn btn-sm btn-gradient-primary" type="button">Tambahkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Select Biasa</h4>
                <p class="card-description"> Standar HTML dropdown </p>
                <div class="form-group">
                    <label>Pilih Kota:</label>
                    <select id="selectKota" class="form-control border-primary">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="mt-3">
                    <p class="text-muted">Kota Terpilih: <span id="hasil1" class="text-primary font-weight-bold"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Select 2 (Searchable)</h4>
                <p class="card-description"> Dropdown dengan fitur pencarian </p>
                <div class="form-group">
                    <label>Pilih Kota:</label>
                    <select id="selectKota2" class="form-control js-example-basic-single" style="width:100%">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>
                <div class="mt-3">
                    <p class="text-muted">Kota Terpilih: <span id="hasil2" class="text-primary font-weight-bold"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS SELECT2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Penyesuaian Select2 agar cocok dengan Purple Admin */
    .select2-container--default .select2-selection--single {
        border: 1px solid #ebedf2;
        height: 45px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px;
    }
</style>

{{-- JS SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('#selectKota2').select2({
        placeholder: "-- Pilih Kota --",
        allowClear: true
    });

    // Fungsi Tambah
    $('#btnTambah').on('click', function() {
        let input = $('#kotaInput');
        let kota = input.val();

        if(!kota) {
            alert("Kota harus diisi!");
            return;
        }

        // Tambah ke Select Biasa
        $('#selectKota').append(new Option(kota, kota));

        // Tambah ke Select2
        $('#selectKota2').append(new Option(kota, kota)).trigger('change');

        // Reset Input
        input.val("");
    });

    // Event Change Select Biasa
    $('#selectKota').on('change', function() {
        $('#hasil1').text($(this).val());
    });

    // Event Change Select2
    $('#selectKota2').on('change', function() {
        $('#hasil2').text($(this).val());
    });
});
</script>
@endsection