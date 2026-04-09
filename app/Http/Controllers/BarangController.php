<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // Menampilkan halaman utama
    public function index()
    {
        return view('Barang.Index'); // Pastikan huruf besar/kecil sesuai nama file view kamu
    }

    // Mengambil data untuk ditampilkan di tabel
    public function data()
    {
        $barang = DB::table('barang')->get();
        return response()->json($barang);
    }

    // Menyimpan data baru
    public function store(Request $req)
    {
        $id = uniqid();

        DB::table('barang')->insert([
            'id_barang' => $id,
            'nama' => $req->nama,
            'harga' => $req->harga
        ]);

        return response()->json(['success' => true, 'pesan' => 'Berhasil ditambah']);
    }

    // Mengubah data
    public function update(Request $req)
    {
        DB::table('barang')
            ->where('id_barang', $req->id)
            ->update([
                'nama' => $req->nama,
                'harga' => $req->harga
            ]);

        return response()->json(['success' => true, 'pesan' => 'Berhasil diubah']);
    }

    // Menghapus data
    public function delete(Request $req)
    {
        DB::table('barang')
            ->where('id_barang', $req->id)
            ->delete();

        return response()->json(['success' => true, 'pesan' => 'Berhasil dihapus']);
    }
}