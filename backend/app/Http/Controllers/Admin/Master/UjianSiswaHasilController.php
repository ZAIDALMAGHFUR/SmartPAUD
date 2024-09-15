<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class UjianSiswaHasilController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ujianSiswaHasil = App\Models\Master\UjianSiswaHasil::with(['ujiansiswa', 'soalujianpg', 'soalujianessay', 'guru'])
            ->where('statusenabled', true)
            ->paginate($perPage);

        if ($ujianSiswaHasil->isEmpty()) {
            return $this->failedResponse('No Ujian Siswa Hasil records found');
        }

        return $this->successResponse('Ujian Siswa Hasil records retrieved successfully', $ujianSiswaHasil);
    }

    public function show($id)
    {
        $ujianSiswaHasil = App\Models\Master\UjianSiswaHasil::with(['ujiansiswa', 'soalujianpg', 'soalujianessay', 'guru'])
            ->find($id);

        if ($ujianSiswaHasil) {
            return $this->successResponse('Ujian Siswa Hasil record retrieved successfully', $ujianSiswaHasil);
        } else {
            return $this->failedResponse('Ujian Siswa Hasil record not found');
        }
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'ujiansiswa_id' => 'required',
                'jawaban' => 'required',
                'ragu' => 'required',
                'status' => 'required',
                'guru_id' => 'required',
                'komentar_guru' => 'required',
            ]);

            $ujianSiswaHasil = App\Models\Master\UjianSiswaHasil::create([
                'kdprofile' => $request->kdprofile,
                'statusenabled' => true,
                'ujiansiswa_id' => $request->ujiansiswa_id,
                'soalujianpg_id' => $request->soalujianpg_id,
                'soalujianessay_id' => $request->soalujianessay_id,
                'jawaban' => $request->jawaban,
                'ragu' => $request->ragu,
                'status' => $request->status,
                'guru_id' => $request->guru_id,
                'komentar_guru' => $request->komentar_guru,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($ujianSiswaHasil));
            return $this->successCreatedResponse('Ujian Siswa Hasil created successfully', $ujianSiswaHasil);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $ujianSiswaHasil = App\Models\Master\UjianSiswaHasil::find($id);

        if ($ujianSiswaHasil) {
            $ujianSiswaHasil->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'ujiansiswa_id' => $request->ujiansiswa_id,
                'soalujianpg_id' => $request->soalujianpg_id,
                'soalujianessay_id' => $request->soalujianessay_id,
                'jawaban' => $request->jawaban,
                'ragu' => $request->ragu,
                'status' => $request->status,
                'guru_id' => $request->guru_id,
                'komentar_guru' => $request->komentar_guru,
            ]);
            $log = $this->logActivity('Update', $request, json_encode(value: $ujianSiswaHasil));
            return $this->successResponse('Ujian Siswa Hasil Updated successfully', $ujianSiswaHasil);
        } else {
            return $this->failedResponse('Ujian Siswa Hasil not found');
        }
    }

    public function destroy(Request $request, $id)
    {
        $ujianSiswaHasil = App\Models\Master\UjianSiswaHasil::find($id);

        if ($ujianSiswaHasil) {
            $ujianSiswaHasil->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode(value: $ujianSiswaHasil));
            return $this->successResponse('Ujian Siswa Hasil deleted successfully', $ujianSiswaHasil);
        } else {
            return $this->failedResponse('Ujian Siswa Hasil not found');
        }
    }
}
