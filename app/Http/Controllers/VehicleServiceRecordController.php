<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleServiceRecord;
use Illuminate\Support\Facades\Validator;

class VehicleServiceRecordController extends Controller
{
    /**
     * Menampilkan daftar catatan layanan kendaraan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /**
         * Mendapatkan semua catatan layanan kendaraan dari database.
         *
         * @var \Illuminate\Database\Eloquent\Collection
         */
        $serviceRecords = VehicleServiceRecord::all();

        return response()->json(['service_records' => $serviceRecords], 200);
    }

    /**
     * Menyimpan catatan layanan kendaraan yang baru dibuat ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        /**
         * Validasi data yang diterima dari permintaan untuk menyimpan catatan layanan kendaraan baru.
         *
         * @var \Illuminate\Validation\Validator
         */
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        /**
         * Membuat catatan layanan kendaraan baru dalam database berdasarkan data yang diterima.
         *
         * @var \App\Models\VehicleServiceRecord
         */
        $serviceRecord = VehicleServiceRecord::create($request->all());

        return response()->json(['service_record' => $serviceRecord], 201);
    }

    /**
     * Menampilkan detail catatan layanan kendaraan yang ditentukan.
     *
     * @param  \App\Models\VehicleServiceRecord  $serviceRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(VehicleServiceRecord $serviceRecord)
    {
        return response()->json(['service_record' => $serviceRecord], 200);
    }

    /**
     * Mengupdate informasi catatan layanan kendaraan yang ditentukan dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleServiceRecord  $serviceRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, VehicleServiceRecord $serviceRecord)
    {
        /**
         * Validasi data yang diterima dari permintaan untuk mengupdate catatan layanan kendaraan.
         *
         * @var \Illuminate\Validation\Validator
         */
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        /**
         * Mengupdate informasi catatan layanan kendaraan yang ditentukan dalam database berdasarkan data yang diterima.
         */
        $serviceRecord->update($request->all());

        return response()->json(['message' => 'Vehicle service record updated successfully'], 200);
    }

    /**
     * Menghapus catatan layanan kendaraan yang ditentukan dari database.
     *
     * @param  \App\Models\VehicleServiceRecord  $serviceRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(VehicleServiceRecord $serviceRecord)
    {
        /**
         * Menghapus catatan layanan kendaraan yang ditentukan dari database.
         */
        $serviceRecord->delete();

        return response()->json(['message' => 'Vehicle service record deleted successfully'], 200);
    }

    /**
     * Mendapatkan aturan validasi untuk permintaan.
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'chassis_number' => 'required|string|max:255',
            'license_plate_number' => 'required|string|max:255',
            'interval_to_now_id' => 'required|exists:interval_to_now,id',
            'last_service' => 'nullable|date',
            'customer_name' => 'required|string|max:255',
            'customer_phone_number' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
            'delivery_date' => 'required|date',
            'service_advisor_name' => 'required|string|max:255',
            'program_name' => 'required|string|max:255',
            'sales_branch' => 'required|string|max:255',
        ];
    }
}
