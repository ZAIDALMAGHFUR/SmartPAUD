<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App;

class StatusSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $statusSiswas = Cache::remember('status_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\StatusSiswa::where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($statusSiswas->isEmpty()) {
            return $this->failedResponse('Status Siswa not found');
        } else {
            return $this->successResponse('Status Siswa retrieved successfully', $statusSiswas);
        }
    }

    public function show($id)
    {
        $statusSiswa = App\Models\Master\StatusSiswa::find($id);

        if ($statusSiswa) {
            return $this->successResponse('Status Siswa retrieved successfully', $statusSiswa);
        } else {
            return $this->failedResponse('Status Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $statusSiswa = App\Models\Master\StatusSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusSiswa));
            return $this->successResponse('Status Siswa created successfully', $statusSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $statusSiswa = App\Models\Master\StatusSiswa::find($id);

            if ($statusSiswa) {
                $statusSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($statusSiswa));
                return $this->successResponse('Status Siswa updated successfully', $statusSiswa);
            } else {
                return $this->failedResponse('Status Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $statusSiswa = App\Models\Master\StatusSiswa::find($id);

            if ($statusSiswa) {
                $statusSiswa->update([
                    'statusenabled' => 0,
                ]);

                $log = $this->logActivity('Delete', $request, json_encode($statusSiswa));
                return $this->successResponse('Status Siswa deleted successfully', $statusSiswa);
            } else {
                return $this->failedResponse('Status Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
