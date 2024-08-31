<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class TahunAjaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $tahunajarans = App\Models\Master\TahunAjaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($tahunajarans->isEmpty()) {
            return $this->failedResponse('Tahun Ajaran not found');
        } else {
            return $this->successResponse('Tahun Ajaran retrieved successfully', $tahunajarans);
        }
    }

    public function show($id)
    {
        $tahunajaran = App\Models\Master\TahunAjaran::find($id);

        if ($tahunajaran) {
            return $this->successResponse('Tahun Ajaran retrieved successfully', $tahunajaran);
        } else {
            return $this->failedResponse('Tahun Ajaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $tahunajaran = App\Models\Master\TahunAjaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($tahunajaran));
            return $this->successCreatedResponse('Tahun Ajaran created successfully', $tahunajaran);
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

            $tahunajaran = App\Models\Master\TahunAjaran::find($id);
            $tahunajaran->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($tahunajaran));
            return $this->successUpdatedResponse('Tahun Ajaran updated successfully', $tahunajaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $tahunajaran = App\Models\Master\TahunAjaran::find($id);

        if ($tahunajaran) {
            $tahunajaran->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($tahunajaran));
            return $this->successDeletedResponse('Tahun Ajaran deleted successfully', $tahunajaran);
        } else {
            return $this->failedResponse('Tahun Ajaran not found');
        }
    }
}
