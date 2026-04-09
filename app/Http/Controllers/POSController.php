<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    /**
     * Fungsi untuk mengambil satu data barang berdasarkan kode/ID
     * Digunakan oleh Axios di halaman POS
     */
    public function getBarang($kode)
    {
        // REVISI: Nama tabel 'barang', nama kolom primary key 'id_barang'
        $barang = DB::table('barang')->where('id_barang', $kode)->first();

        if ($barang) {
            return response()->json($barang);
        }

        // Return null jika barang tidak ditemukan
        return response()->json(null);
    }

    /**
     * Fungsi untuk memproses transaksi pembayaran
     */
    public function bayar(Request $req)
    {
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel penjualans (Induk)
            // Pastikan tabel 'penjualans' sudah ada di database kamu
            $id = DB::table('penjualans')->insertGetId([
                'timestamp' => now(),
                'total' => $req->total,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Simpan detail barang yang dibeli ke tabel penjualan_details
            foreach ($req->items as $item) {
                DB::table('penjualan_details')->insert([
                    'id_penjualan' => $id,
                    'id_barang'    => $item['kode'], // Ini berisi id_barang
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $item['subtotal'],
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            DB::rollBack();
            // Mengembalikan pesan error asli jika gagal untuk debugging
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}