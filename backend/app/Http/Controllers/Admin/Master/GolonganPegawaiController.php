<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class GolonganPegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $golonganPegawais = App\Models\Master\GolonganPegawai::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($golonganPegawais->isEmpty()) {
            return $this->failedResponse('Golongan Pegawai not found');
        } else {
            return $this->successResponse('Golongan Pegawai retrieved successfully', $golonganPegawais);
        }
    }

    public function show($id)
    {
        $golonganPegawai = App\Models\Master\GolonganPegawai::find($id);

        if ($golonganPegawai) {
            return $this->successResponse('Golongan Pegawai retrieved successfully', $golonganPegawai);
        } else {
            return $this->failedResponse('Golongan Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $golonganPegawai = App\Models\Master\GolonganPegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($golonganPegawai));
            return $this->successCreatedResponse('Golongan Pegawai created successfully', $golonganPegawai);
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

            $golonganPegawai = App\Models\Master\GolonganPegawai::find($id);
            $golonganPegawai->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($golonganPegawai));
            return $this->successResponse('Golongan Pegawai updated successfully', $golonganPegawai);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $golonganPegawai = App\Models\Master\GolonganPegawai::find($id);

        if ($golonganPegawai) {
            $golonganPegawai->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($golonganPegawai));
            return $this->successResponse('Golongan Pegawai deleted successfully', $golonganPegawai);
        } else {
            return $this->failedResponse('Golongan Pegawai not found');
        }
    }
}
