<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{

    public function generate()
    {
        $buku = DB::table('buku')
        ->join('kategori','buku.kategori_id','=','kategori.id')
        ->select('buku.*','kategori.nama as nama_kategori')
        ->get();

        $pdf = Pdf::loadView('pdf', compact('buku'));

        return $pdf->stream('laporan-buku.pdf');
    }


    public function cetakLabel(Request $request)
    {

        $barang = DB::table('barang')
        ->whereIn('id_barang',$request->barang)
        ->get();

        $x = $request->x;
        $y = $request->y;

        $pdf = Pdf::loadView('label',[
            'barang'=>$barang,
            'x'=>$x,
            'y'=>$y
        ]);

        return $pdf->stream('label-barang.pdf');

    }

}