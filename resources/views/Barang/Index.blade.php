@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Tambah Barang</h2>
        
        {{-- Form beneran ke Database --}}
        <form action="{{ url('barang-store') }}" method="POST" class="forms-sample">
            @csrf
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Submit ke Database</button>
        </form>

        <hr class="my-4">

        <h3 class="card-title">Data Barang (Dari Database)</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
@foreach($barangs as $b)
<tr>
    {{-- Ganti $b->id menjadi $b->id_barang --}}
    <td>{{ $b->id_barang }}</td> 
    
    {{-- Pastikan juga kolom nama sesuai dengan di database (kemungkinan 'nama') --}}
    <td>{{ $b->nama }}</td> 
    
    <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
    <td>
        {{-- Ganti link delete agar mengarah ke id_barang --}}
        <form action="{{ url('barang-delete/'.$b->id_barang) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </form>
    </td>
</tr>
@endforeach
            </table>
        </div>
    </div>
</div>
@endsection