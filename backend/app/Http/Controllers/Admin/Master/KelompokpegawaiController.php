<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class KelompokpegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $kelompokpegawais = App\Models\Master\Kelompokpegawai::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($kelompokpegawais->isEmpty()) {
            return $this->failedResponse('Kelompok Pegawai not found');
        } else {
            return $this->successResponse('Kelompok Pegawai retrieved successfully', $kelompokpegawais);
        }
    }

    public function show($id)
    {
        $kelompokpegawai = App\Models\Master\Kelompokpegawai::find($id);

        if ($kelompokpegawai) {
            return $this->successResponse('Kelompok Pegawai retrieved successfully', $kelompokpegawai);
        } else {
            return $this->failedResponse('Kelompok Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $kelompokpegawai = App\Models\Master\Kelompokpegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($kelompokpegawai));
            return $this->successCreatedResponse('Kelompok Pegawai created successfully', $kelompokpegawai);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $kelompokpegawai = App\Models\Master\Kelompokpegawai::find($id);
            $kelompokpegawai->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($kelompokpegawai));
            return $this->successResponse('Kelompok Pegawai updated successfully', $kelompokpegawai);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $kelompokpegawai = App\Models\Master\Kelompokpegawai::find($id);

        if ($kelompokpegawai) {
            $kelompokpegawai->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($kelompokpegawai));
            return $this->successResponse('Kelompok Pegawai deleted successfully', $kelompokpegawai);
        } else {
            return $this->failedResponse('Kelompok Pegawai not found');
        }
    }
}
