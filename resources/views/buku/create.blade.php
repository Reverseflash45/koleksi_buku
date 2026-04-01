@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah Buku</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/buku/tambah" method="POST">
            @csrf

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-2">
                <label>Kode</label>
                <input type="text" name="kode" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Pengarang</label>
                <input type="text" name="pengarang" class="form-control" required>
            </div>

            <button class="btn btn-primary mt-3">Simpan</button>
            <a href="/buku" class="btn btn-light mt-3">Kembali</a>
        </form>

    </div>
</div>

@endsection
