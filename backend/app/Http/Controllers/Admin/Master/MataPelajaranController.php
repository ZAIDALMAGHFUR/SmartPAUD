<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class MataPelajaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $mataPelajarans = App\Models\Master\MataPelajaran::with(['jenjangpendidikan'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($mataPelajarans->isEmpty()) {
            return $this->failedResponse('Mata Pelajaran not found');
        } else {
            return $this->successResponse('Mata Pelajaran retrieved successfully', $mataPelajarans);
        }
    }

    public function show($id)
    {
        $mataPelajaran = App\Models\Master\MataPelajaran::with(['jenjangpendidikan'])->find($id);

        if ($mataPelajaran) {
            return $this->successResponse('Mata Pelajaran retrieved successfully', $mataPelajaran);
        } else {
            return $this->failedResponse('Mata Pelajaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'jenjangpendidikan_id' => 'required',
            ]);

            $mataPelajaran = App\Models\Master\MataPelajaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
                'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($mataPelajaran));
            return $this->successCreatedResponse('Mata Pelajaran created successfully', $mataPelajaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $mataPelajaran = App\Models\Master\MataPelajaran::find($id);

            if ($mataPelajaran) {
                $request->validate([
                    'name' => 'required',
                    'jenjangpendidikan_id' => 'required',
                ]);

                $mataPelajaran->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                    'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($mataPelajaran));
                return $this->successResponse('Mata Pelajaran updated successfully', $mataPelajaran);
            } else {
                return $this->failedResponse('Mata Pelajaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $mataPelajaran = App\Models\Master\MataPelajaran::find($id);

        if ($mataPelajaran) {
            $mataPelajaran->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($mataPelajaran));
            return $this->successResponse('Mata Pelajaran deleted successfully', $mataPelajaran);
        } else {
            return $this->failedResponse('Mata Pelajaran not found');
        }
    }
}
