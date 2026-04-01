<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth\GoogleCallbackController;
use App\Http\Controllers\PdfController;


Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    });

    // =====================
    // KATEGORI
    // =====================

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

    // =====================
    // BUKU
    // =====================

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

});


Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->user();

    // cek user sudah ada atau belum
    $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = \App\Models\User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt('google-login')
        ]);
    }

    Auth::login($user);

    return redirect('/');
});

Route::get('/callback', function () {

    $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')
        ->stateless()
        ->user();

    $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = \App\Models\User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt('google-login')
        ]);
    }

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect('/');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'index'])
        ->name('verify');

});

Route::get('/pdf', [PdfController::class, 'generate'])->name('pdf.generate');


Route::post('/verify', [App\Http\Controllers\Auth\VerificationController::class, 'store']);
Route::get('/verify', [VerificationController::class, 'index'])->middleware('auth');
Route::post('/verify', [VerificationController::class, 'store'])->middleware('auth');
Route::post('/cetak-label', [PdfController::class, 'cetakLabel'])->name('cetak.label');
Route::get('/pdf', [PdfController::class, 'generate'])->name('pdf.generate');
Route::post('/cetak-label', [PdfController::class, 'cetakLabel'])->name('cetak.label');


/*
|--------------------------------------------------------------------------
| BARANG CRUD
|--------------------------------------------------------------------------
*/

Route::get('/barang', function () {

    $barang = DB::table('barang')->get();

    return view('Barang.index', compact('barang'));

});


Route::post('/barang/tambah', function (Request $request) {

    DB::table('barang')->insert([
        'nama' => $request->nama,
        'harga' => $request->harga
    ]);

    return redirect('/barang');

});


Route::post('/barang/hapus/{id}', function ($id) {

    DB::table('barang')->where('id_barang',$id)->delete();

    return redirect('/barang');

});

Route::get('/kota', function () {
    return view('kota.index');
});

Route::post('/cetak-label', [PdfController::class,'cetakLabel'])->name('cetak.label');

