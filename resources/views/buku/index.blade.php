@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Buku</h3>
</div>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $b)
                        <tr>
                            <td>{{ $b->nama_kategori }}</td>
                            <td>{{ $b->kode }}</td>
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->pengarang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<a href="/buku/tambah" class="btn btn-primary mb-3">Tambah Buku</a>
    </div>
</div>

@endsection

