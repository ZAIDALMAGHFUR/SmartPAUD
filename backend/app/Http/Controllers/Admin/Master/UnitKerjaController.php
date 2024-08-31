<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class UnitKerjaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $unitKerja = App\Models\Master\UnitKerja::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($unitKerja->isEmpty()) {
            return $this->failedResponse('Unit Kerja not found');
        } else {
            return $this->successResponse('Unit Kerja retrieved successfully', $unitKerja);
        }
    }

    public function show($id)
    {
        $unitKerja = App\Models\Master\UnitKerja::find($id);

        if ($unitKerja) {
            return $this->successResponse('Unit Kerja retrieved successfully', $unitKerja);
        } else {
            return $this->failedResponse('Unit Kerja not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $unitKerja = App\Models\Master\UnitKerja::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($unitKerja));
            return $this->successCreatedResponse('Unit Kerja created successfully', $unitKerja);
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

            $unitKerja = App\Models\Master\UnitKerja::find($id);
            $unitKerja->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($unitKerja));
            return $this->successResponse('Unit Kerja updated successfully', $unitKerja);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $unitKerja = App\Models\Master\UnitKerja::find($id);

        if ($unitKerja) {
            $unitKerja->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($unitKerja));
            return $this->successResponse('Unit Kerja deleted successfully', $unitKerja);
        } else {
            return $this->failedResponse('Unit Kerja not found');
        }
    }
}
