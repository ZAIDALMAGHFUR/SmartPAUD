<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class KelasController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $kelases = App\Models\Master\Kelas::with(['jenjangpendidikan'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($kelases->isEmpty()) {
            return $this->failedResponse('Kelas not found');
        } else {
            return $this->successResponse('Kelas retrieved successfully', $kelases);
        }
    }

    public function show($id)
    {
        $kelas = App\Models\Master\Kelas::with(['jenjangpendidikan'])->find($id);

        if ($kelas) {
            return $this->successResponse('Kelas retrieved successfully', $kelas);
        } else {
            return $this->failedResponse('Kelas not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'jenjangpendidikan_id' => 'required',
            ]);

            $kelas = App\Models\Master\Kelas::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
                'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($kelas));
            return $this->successCreatedResponse('Kelas created successfully', $kelas);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'jenjangpendidikan_id' => 'required',
            ]);

            $kelas = App\Models\Master\Kelas::find($id);
            $kelas->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
                'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($kelas));
            return $this->successResponse('Kelas updated successfully', $kelas);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $kelas = App\Models\Master\Kelas::find($id);

        if ($kelas) {
            $kelas->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($kelas));
            return $this->successResponse('Kelas deleted successfully');
        } else {
            return $this->failedResponse('Kelas not found');
        }
    }
}
