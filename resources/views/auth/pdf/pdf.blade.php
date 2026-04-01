<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Cetak Label</title>

<style>

@page{
    margin:10mm;
}

body{
    font-family:Arial, Helvetica, sans-serif;
}

table{
    border-collapse:collapse;
}

td{
    width:38mm;
    height:21mm;
    text-align:center;
    vertical-align:middle;
    font-size:12px;
}

.nama{
    font-weight:bold;
}

.harga{
    font-weight:bold;
}

</style>

</head>

<body>

@php
$start = (($y-1)*5)+$x;
@endphp

<table>

@for($row=1;$row<=8;$row++)
<tr>

@for($col=1;$col<=5;$col++)

<td>

@php
$pos = ($row-1)*5+$col;
@endphp

@if($pos >= $start && isset($labels[$pos-$start]))

<div class="nama">
{{ $labels[$pos-$start]->nama }}
</div>

<div class="harga">
Rp {{ number_format($labels[$pos-$start]->harga) }}
</div>

@endif

</td>

@endfor

</tr>
@endfor

</table>

</body>
</html>