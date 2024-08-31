<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusPegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $statusPegawais = App\Models\Master\StatusPegawai::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($statusPegawais->isEmpty()) {
            return $this->failedResponse('Status Pegawai not found');
        } else {
            return $this->successResponse('Status Pegawai retrieved successfully', $statusPegawais);
        }
    }

    public function show($id)
    {
        $statusPegawai = App\Models\Master\StatusPegawai::find($id);

        if ($statusPegawai) {
            return $this->successResponse('Status Pegawai retrieved successfully', $statusPegawai);
        } else {
            return $this->failedResponse('Status Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $statusPegawai = App\Models\Master\StatusPegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusPegawai));
            return $this->successCreatedResponse('Status Pegawai created successfully', $statusPegawai);
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

            $statusPegawai = App\Models\Master\StatusPegawai::find($id);
            $statusPegawai->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($statusPegawai));
            return $this->successResponse('Status Pegawai updated successfully', $statusPegawai);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $statusPegawai = App\Models\Master\StatusPegawai::find($id);

        if ($statusPegawai) {
            $statusPegawai->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($statusPegawai));
            return $this->successResponse('Status Pegawai deleted successfully', $statusPegawai);
        } else {
            return $this->failedResponse('Status Pegawai not found');
        }
    }
}
