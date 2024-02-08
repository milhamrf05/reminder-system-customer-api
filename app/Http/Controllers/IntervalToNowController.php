<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IntervalToNow;

class IntervalToNowController extends Controller
{
    /**
     * Menampilkan daftar interval.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /**
         * Mendapatkan semua data interval dari database.
         *
         * @var \Illuminate\Database\Eloquent\Collection
         */
        $intervals = IntervalToNow::all();

        return response()->json(['intervals' => $intervals], 200);
    }

    /**
     * Menyimpan interval yang baru dibuat ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        /**
         * Validasi data yang diterima dari permintaan untuk menyimpan interval baru.
         *
         * @var \Illuminate\Validation\Validator
         */
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        /**
         * Membuat interval baru dalam database berdasarkan data yang diterima.
         *
         * @var \App\Models\IntervalToNow
         */
        $interval = IntervalToNow::create([
            'name' => $request->name,
        ]);

        return response()->json(['interval' => $interval], 201);
    }

    /**
     * Menampilkan detail interval yang ditentukan.
     *
     * @param  \App\Models\IntervalToNow  $intervalToNow
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(IntervalToNow $intervalToNow)
    {
        return response()->json(['interval' => $intervalToNow], 200);
    }

    /**
     * Mengupdate informasi interval yang ditentukan dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IntervalToNow  $intervalToNow
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, IntervalToNow $intervalToNow)
    {
        /**
         * Validasi data yang diterima dari permintaan untuk mengupdate interval.
         *
         * @var \Illuminate\Validation\Validator
         */
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        /**
         * Mengupdate informasi interval yang ditentukan dalam database berdasarkan data yang diterima.
         */
        $intervalToNow->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Interval updated successfully'], 200);
    }

    /**
     * Menghapus interval yang ditentukan dari database.
     *
     * @param  \App\Models\IntervalToNow  $intervalToNow
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(IntervalToNow $intervalToNow)
    {
        /**
         * Menghapus interval yang ditentukan dari database.
         */
        $intervalToNow->delete();

        return response()->json(['message' => 'Interval deleted successfully'], 200);
    }
}
