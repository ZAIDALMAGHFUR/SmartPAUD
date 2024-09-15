<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class UjianSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $ujiansiswa = App\Models\Master\UjianSiswa::with(['ujian', 'siswa'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($ujiansiswa->isEmpty()) {
            return $this->failedResponse('No UjianSiswa records found');
        }

        return $this->successResponse('UjianSiswa records retrieved successfully', $ujiansiswa);
    }

    public function show($id)
    {
        $ujiansiswa = App\Models\Master\UjianSiswa::with(['ujian', 'siswa'])->find($id);

        if ($ujiansiswa) {
            return $this->successResponse('UjianSiswa record retrieved successfully', $ujiansiswa);
        } else {
            return $this->failedResponse('UjianSiswa record not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ujian_id' => 'required',
                'siswa_id' => 'required',
                'nilai' => 'numeric',
            ]);

            $ujiansiswa = App\Models\Master\UjianSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'ujian_id' => $request->ujian_id,
                'siswa_id' => $request->siswa_id,
                'started_at' => $request->started_at,
                'ended_at' => $request->ended_at,
                'nilai' => $request->nilai,
                'user_agent' => $request->user_agent,
                'ip_address' => $request->ip_address,
                'status' => $request->status ?? '0',
            ]);

            $log = $this->logActivity('Create', $request, json_encode($ujiansiswa));
            return $this->successCreatedResponse('UjianSiswa created successfully', $ujiansiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'ujian_id' => 'required',
                'siswa_id' => 'required',
                'nilai' => 'numeric',
            ]);

            $ujiansiswa = App\Models\Master\UjianSiswa::find($id);

            if ($ujiansiswa) {
                $ujiansiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'ujian_id' => $request->ujian_id,
                    'siswa_id' => $request->siswa_id,
                    'started_at' => $request->started_at,
                    'ended_at' => $request->ended_at,
                    'nilai' => $request->nilai,
                    'user_agent' => $request->user_agent,
                    'ip_address' => $request->ip_address,
                    'status' => $request->status ?? '0',
                ]);

                $log = $this->logActivity('Update', $request, json_encode($ujiansiswa));
                return $this->successResponse('UjianSiswa updated successfully', $ujiansiswa);
            } else {
                return $this->failedResponse('UjianSiswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $ujiansiswa = App\Models\Master\UjianSiswa::find($id);

        if ($ujiansiswa) {
            $ujiansiswa->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($ujiansiswa));
            return $this->successResponse('UjianSiswa deleted successfully', $ujiansiswa);
        } else {
            return $this->failedResponse('UjianSiswa not found');
        }
    }
}
