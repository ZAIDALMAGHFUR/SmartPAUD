<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class HubunganKeluargaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $hubungankeluargas = App\Models\Master\HubunganKeluarga::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($hubungankeluargas->isEmpty()) {
            return $this->failedResponse('Hubungan Keluarga not found');
        } else {
            return $this->successResponse('Hubungan Keluarga retrieved successfully', $hubungankeluargas);
        }
    }

    public function show($id)
    {
        $hubungankeluarga = App\Models\Master\HubunganKeluarga::find($id);

        if ($hubungankeluarga) {
            return $this->successResponse('Hubungan Keluarga retrieved successfully', $hubungankeluarga);
        } else {
            return $this->failedResponse('Hubungan Keluarga not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $hubungankeluarga = App\Models\Master\HubunganKeluarga::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($hubungankeluarga));
            return $this->successCreatedResponse('Hubungan Keluarga created successfully', $hubungankeluarga);
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

            $hubungankeluarga = App\Models\Master\HubunganKeluarga::find($id);
            $hubungankeluarga->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($hubungankeluarga));
            return $this->successResponse('Hubungan Keluarga updated successfully', $hubungankeluarga);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $hubungankeluarga = App\Models\Master\HubunganKeluarga::find($id);

        if ($hubungankeluarga) {
            $hubungankeluarga->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($hubungankeluarga));
            return $this->successResponse('Hubungan Keluarga deleted successfully', $hubungankeluarga);
        } else {
            return $this->failedResponse('Hubungan Keluarga not found');
        }
    }
}
