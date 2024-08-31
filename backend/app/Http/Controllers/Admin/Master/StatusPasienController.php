<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusPasienController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $statusPasiens = App\Models\Master\StatusPasien::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($statusPasiens->isEmpty()) {
            return $this->failedResponse('Status Pasien not found');
        } else {
            return $this->successResponse('Status Pasien retrieved successfully', $statusPasiens);
        }
    }

    public function show($id)
    {
        $statusPasien = App\Models\Master\StatusPasien::find($id);

        if ($statusPasien) {
            return $this->successResponse('Status Pasien retrieved successfully', $statusPasien);
        } else {
            return $this->failedResponse('Status Pasien not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $statusPasien = App\Models\Master\StatusPasien::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusPasien));
            return $this->successCreatedResponse('Status Pasien created successfully', $statusPasien);
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

            $statusPasien = App\Models\Master\StatusPasien::find($id);
            $statusPasien->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($statusPasien));
            return $this->successResponse('Status Pasien updated successfully', $statusPasien);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $statusPasien = App\Models\Master\StatusPasien::find($id);

        if ($statusPasien) {
            $statusPasien->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($statusPasien));
            return $this->successResponse('Status Pasien deleted successfully', $statusPasien);
        } else {
            return $this->failedResponse('Status Pasien not found');
        }
    }
}
