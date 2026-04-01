@extends('layouts.app') {{-- atau layout template kamu --}}

@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="card-title">Data Kategori</h4>

        <a href="{{ url('/kategori/tambah') }}" class="btn btn-gradient-primary mb-3">
            Tambah Kategori
        </a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">
                                Belum ada data kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
