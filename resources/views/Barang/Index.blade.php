<!DOCTYPE html>
<html>
<head>

<title>Data Barang</title>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body>

<h2>Data Barang</h2>

<!-- ========================
FORM CETAK LABEL
======================== -->

<form action="{{ route('cetak.label') }}" method="POST">

@csrf

<label>Koordinat X</label>
<input type="number" name="x" required min="1" max="5">

<label>Koordinat Y</label>
<input type="number" name="y" required min="1" max="8">

<br><br>

<table id="tableBarang" border="1" cellpadding="6">

<thead>

<tr>
<th>Pilih</th>
<th>ID</th>
<th>Nama</th>
<th>Harga</th>
</tr>

</thead>

<tbody>

@foreach($barang as $b)

<tr>

<td>
<input type="checkbox" name="barang[]" value="{{ $b->id_barang }}">
</td>

<td>{{ $b->id_barang }}</td>
<td>{{ $b->nama }}</td>
<td>Rp {{ number_format($b->harga) }}</td>

</tr>

@endforeach

</tbody>

</table>

<br>

<button type="submit">Cetak Label</button>

</form>

<hr>

<!-- ========================
TAMBAH BARANG
======================== -->

<h3>Tambah Barang</h3>

<form action="/barang/tambah" method="POST">

@csrf

<label>Nama Barang</label>
<input type="text" name="nama" required>

<label>Harga</label>
<input type="number" name="harga" required>

<button type="submit">Tambah</button>

</form>

<hr>

<!-- ========================
DAFTAR BARANG + HAPUS
======================== -->

<h3>Daftar Barang</h3>

<table border="1" cellpadding="6">

<tr>
<th>ID</th>
<th>Nama</th>
<th>Harga</th>
<th>Aksi</th>
</tr>

@foreach($barang as $b)

<tr>

<td>{{ $b->id_barang }}</td>
<td>{{ $b->nama }}</td>
<td>{{ $b->harga }}</td>

<td>

<form action="/barang/hapus/{{ $b->id_barang }}" method="POST">

@csrf

<button type="submit">Hapus</button>

</form>

</td>

</tr>

@endforeach

</table>


<script>

$(document).ready(function(){

$('#tableBarang').DataTable();

});

</script>

</body>
</html>