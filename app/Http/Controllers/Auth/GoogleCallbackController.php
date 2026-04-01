<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class GoogleCallbackController extends Controller
{
    public function __invoke()
    {
        try {

            // ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            // kalau belum ada → buat user baru
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('google-login'), // password dummy
                ]);
            }

            // login user
            Auth::login($user);

            return redirect('/');

        } catch (Exception $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}
