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

    public function getBarang($kode)
    {
        return DB::table('barang')->where('id_barang', $kode)->first();
    }

    public function bayar(Request $req)
    {
        DB::beginTransaction();

        try {
            $id = DB::table('penjualan')->insertGetId([
                'timestamp' => now(),
                'total' => $req->total
            ]);

            foreach ($req->items as $item) {
                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $id,
                    'id_barang' => $item['kode'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            DB::commit();
            return response()->json(['status'=>'ok']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>'error']);
        }
    }
}