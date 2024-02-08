<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Mendaftarkan pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        /**
         * Validasi data yang diterima dari permintaan untuk pendaftaran pengguna baru.
         *
         * @var \Illuminate\Validation\Validator
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        /**
         * Membuat pengguna baru dalam database berdasarkan data yang diterima.
         *
         * @var \App\Models\User
         */
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        /**
         * Membuat token untuk otentikasi pengguna baru.
         *
         * @var string
         */
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * Masuk dengan menggunakan informasi pengguna dan membuat token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        /**
         * Validasi kredensial pengguna untuk login.
         *
         * @var array
         */
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /**
         * Mendapatkan pengguna yang sedang masuk dan membuat token otentikasi.
         *
         * @var \App\Models\User
         * @var string
         */
        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Keluar pengguna dan mencabut token otentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        /**
         * Menghapus token otentikasi saat ini untuk keluar pengguna.
         *
         * @var \Laravel\Sanctum\PersonalAccessToken
         */
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
