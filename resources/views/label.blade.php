<!DOCTYPE html>
<html>
<head>

<style>

table{
width:100%;
border-collapse:collapse;
}

td{
width:20%;
height:90px;
border:1px solid #ccc;
text-align:center;
vertical-align:middle;
font-size:12px;
}

.nama{
font-size:14px;
font-weight:bold;
}

.harga{
font-size:18px;
font-weight:bold;
}

</style>

</head>

<body>

<table>

@php

$rows=8;
$cols=5;

$start = (($y-1)*$cols)+($x-1);

$index=0;

@endphp


@for($i=0;$i<$rows;$i++)

<tr>

@for($j=0;$j<$cols;$j++)

<td>

@php
$pos = ($i*$cols)+$j;
@endphp

@if($pos >= $start && isset($barang[$index]))

<div class="nama">
{{ $barang[$index]->nama }}
</div>

<div class="harga">
Rp {{ number_format($barang[$index]->harga) }}
</div>

@php $index++; @endphp

@endif

</td>

@endfor

</tr>

@endfor

</table>

</body>
</html>