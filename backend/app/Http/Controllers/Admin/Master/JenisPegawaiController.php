<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JenisPegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jenisPegawais = App\Models\Master\JenisPegawai::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($jenisPegawais->isEmpty()) {
            return $this->failedResponse('Jenis Pegawai not found');
        } else {
            return $this->successResponse('Jenis Pegawai retrieved successfully', $jenisPegawais);
        }
    }

    public function show($id)
    {
        $jenisPegawai = App\Models\Master\JenisPegawai::find($id);

        if ($jenisPegawai) {
            return $this->successResponse('Jenis Pegawai retrieved successfully', $jenisPegawai);
        } else {
            return $this->failedResponse('Jenis Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jenisPegawai = App\Models\Master\JenisPegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jenisPegawai));
            return $this->successCreatedResponse('Jenis Pegawai created successfully', $jenisPegawai);
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

            $jenisPegawai = App\Models\Master\JenisPegawai::find($id);

            if ($jenisPegawai) {
                $jenisPegawai->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jenisPegawai));
                return $this->successResponse('Jenis Pegawai updated successfully', $jenisPegawai);
            } else {
                return $this->failedResponse('Jenis Pegawai not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jenisPegawai = App\Models\Master\JenisPegawai::find($id);

        if ($jenisPegawai) {
            $jenisPegawai->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jenisPegawai));
            return $this->successResponse('Jenis Pegawai deleted successfully');
        } else {
            return $this->failedResponse('Jenis Pegawai not found');
        }
    }
}
