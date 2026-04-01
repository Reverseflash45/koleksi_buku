<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>

<h3>Laporan Buku</h3>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku as $b)
        <tr>
            <td>{{ $b->kode }}</td>
            <td>{{ $b->judul }}</td>
            <td>{{ $b->pengarang }}</td>
            <td>{{ $b->nama_kategori }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>