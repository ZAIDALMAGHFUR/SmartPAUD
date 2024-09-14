<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class RiawayatKesehatanSiswaController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $riwayatKesehatanSiswa = App\Models\Master\RiawayatKesehatanSiswa::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($riwayatKesehatanSiswa->isEmpty()) {
            return $this->failedResponse('Riwayat Kesehatan Siswa not found');
        } else {
            return $this->successResponse('Riwayat Kesehatan Siswa retrieved successfully', $riwayatKesehatanSiswa);
        }
    }

    public function show($id)
    {
        $riwayatKesehatanSiswa = App\Models\Master\RiawayatKesehatanSiswa::find($id);

        if ($riwayatKesehatanSiswa) {
            return $this->successResponse('Riwayat Kesehatan Siswa retrieved successfully', $riwayatKesehatanSiswa);
        } else {
            return $this->failedResponse('Riwayat Kesehatan Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'penyakit' => 'nullable',
                'riwayatpengobatan' => 'nullable',
                'alergi' => 'nullable',
                'catatankesehatanlainnya' => 'nullable',
            ]);

            $riwayatKesehatanSiswa = App\Models\Master\RiawayatKesehatanSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'siswa_id' => $request->siswa_id,
                'penyakit' => $request->penyakit,
                'riwayatpengobatan' => $request->riwayatpengobatan,
                'alergi' => $request->alergi,
                'catatankesehatanlainnya' => $request->catatankesehatanlainnya,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($riwayatKesehatanSiswa));
            return $this->successCreatedResponse('Riwayat Kesehatan Siswa created successfully', $riwayatKesehatanSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'siswa_id' => 'required|exists:siswa,id',
                'penyakit' => 'nullable',
                'riwayatpengobatan' => 'nullable',
                'alergi' => 'nullable',
                'catatankesehatanlainnya' => 'nullable',
            ]);

            $riwayatKesehatanSiswa = App\Models\Master\RiawayatKesehatanSiswa::find($id);

            if ($riwayatKesehatanSiswa) {
                $riwayatKesehatanSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'siswa_id' => $request->siswa_id,
                    'penyakit' => $request->penyakit,
                    'riwayatpengobatan' => $request->riwayatpengobatan,
                    'alergi' => $request->alergi,
                    'catatankesehatanlainnya' => $request->catatankesehatanlainnya,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($riwayatKesehatanSiswa));
                return $this->successResponse('Riwayat Kesehatan Siswa updated successfully', $riwayatKesehatanSiswa);
            } else {
                return $this->failedResponse('Riwayat Kesehatan Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $riwayatKesehatanSiswa = App\Models\Master\RiawayatKesehatanSiswa::find($id);

        if ($riwayatKesehatanSiswa) {
            $riwayatKesehatanSiswa->delete();
            $log = $this->logActivity('Delete', $request, json_encode($riwayatKesehatanSiswa));
            return $this->successResponse('Riwayat Kesehatan Siswa deleted successfully', $riwayatKesehatanSiswa);
        } else {
            return $this->failedResponse('Riwayat Kesehatan Siswa not found');
        }
    }
}
