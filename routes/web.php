<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\Auth\GoogleCallbackController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\BarangController;

Auth::routes();

// ==========================================
// ROUTE DASHBOARD, KATEGORI & BUKU (AUTH)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    });

    // KATEGORI
    Route::get('/kategori', function () {
        $kategori = DB::table('kategori')->get();
        return view('kategori.index', compact('kategori'));
    });

    Route::get('/kategori/tambah', function () {
        return view('kategori.create');
    });

    Route::post('/kategori/tambah', function (Request $request) {
        DB::table('kategori')->insert([
            'nama' => $request->input('nama')
        ]);
        return redirect('/kategori');
    });

    // BUKU
    Route::get('/buku', function () {
        $buku = DB::table('buku')
            ->join('kategori', 'buku.kategori_id', '=', 'kategori.id')
            ->select('buku.*', 'kategori.nama as nama_kategori')
            ->get();
        return view('buku.index', compact('buku'));
    });

    Route::get('/buku/tambah', function () {
        $kategori = DB::table('kategori')->get();
        return view('buku.create', compact('kategori'));
    });

    Route::post('/buku/tambah', function (Request $request) {
        DB::table('buku')->insert([
            'kategori_id' => $request->input('kategori_id'),
            'kode' => $request->input('kode'),
            'judul' => $request->input('judul'),
            'pengarang' => $request->input('pengarang'),
        ]);
        return redirect('/buku');
    });

    // VERIFY
    Route::get('/verify', [VerificationController::class, 'index'])->name('verify');
    Route::post('/verify', [VerificationController::class, 'store']);

});

// ==========================================
// ROUTE GOOGLE LOGIN
// ==========================================
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt('google-login')
        ]);
    }

    Auth::login($user);
    return redirect('/');
});

Route::get('/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt('google-login')
        ]);
    }

    Auth::login($user);
    return redirect('/');
});


// ==========================================
// ROUTE PDF & CETAK LABEL
// ==========================================
Route::get('/pdf', [PdfController::class, 'generate'])->name('pdf.generate');
Route::post('/cetak-label', [PdfController::class, 'cetakLabel'])->name('cetak.label');


// ==========================================
// ROUTE BARANG (AJAX DARI CONTROLLER)
// ==========================================
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/data', [BarangController::class, 'data']);
Route::post('/barang/tambah', [BarangController::class, 'store']);
Route::post('/barang/ubah', [BarangController::class, 'update']);
Route::post('/barang/hapus', [BarangController::class, 'delete']);


// ==========================================
// ROUTE WILAYAH & KOTA (AJAX DARI CONTROLLER)
// ==========================================
Route::get('/kota', function () {
    return view('kota.index'); // Tampilan tester kota jika kamu pakai file ini
});

Route::get('/wilayah', [WilayahController::class, 'index']); // Tampilan utama wilayah
Route::get('/get-kota/{id}', [WilayahController::class, 'getKota']);
Route::get('/get-kecamatan/{id}', [WilayahController::class, 'getKecamatan']);
Route::get('/get-kelurahan/{id}', [WilayahController::class, 'getKelurahan']);


// ==========================================
// ROUTE POINT OF SALE (POS)
// ==========================================
Route::get('/pos', [POSController::class, 'index']);
Route::get('/barang/{kode}', [POSController::class, 'getBarang']);
Route::post('/bayar', [POSController::class, 'bayar']);