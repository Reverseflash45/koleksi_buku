<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
public function index() {
    // Ganti 'barangs' menjadi 'barang'
    $barangs = DB::table('barang')->get(); 
    return view('Barang.Index', compact('barangs'));
}

public function store(Request $req) {
    $req->validate([
        'nama_barang' => 'required',
        'harga' => 'required|numeric'
    ]);

    DB::table('barang')->insert([
        'id_barang' => rand(100, 999), // Menambahkan ID acak agar database tidak error
        'nama' => $req->nama_barang,
        'harga' => $req->harga,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->back()->with('success', 'Barang berhasil ditambah!');
}

    public function delete($id) {
        DB::table('barangs')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}