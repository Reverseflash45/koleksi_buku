<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index()
    {
        $provinsi = DB::table('reg_provinces')->get();
        return view('wilayah.index', compact('provinsi'));
    }

    public function getKota($id)
    {
        $kota = DB::table('reg_regencies')->where('province_id', $id)->get();
        
        return response()->json($kota);
    }

    public function getKecamatan($id)
    {
        // Ubah nama tabel menjadi reg_districts
        $kecamatan = DB::table('reg_districts')->where('regency_id', $id)->get();
        
        return response()->json($kecamatan);
    }

    public function getKelurahan($id)
    {
        // Ubah nama tabel menjadi reg_villages
        $kelurahan = DB::table('reg_villages')->where('district_id', $id)->get();
        
        return response()->json($kelurahan);
    }
}