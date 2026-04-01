<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verification.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        $otp = rand(100000, 999999);
        $uniqueId = Str::uuid();

        DB::table('verification')->insert([
            'user_id'   => $user->id,
            'unique_id' => $uniqueId,
            'otp'       => md5($otp),
            'tipe'      => 'register',
            'send_via'  => 'email',
            'status'    => 'active',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        return "OTP generated: $otp";
    }
}