@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Kategori</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/kategori/tambah" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <button class="btn btn-primary mt-2">Simpan</button>
            <a href="/kategori" class="btn btn-light mt-2">Kembali</a>
        </form>

    </div>
</div>

@endsection
