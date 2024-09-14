<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App;

class TugasSiswaDetailController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $tugasSiswaDetails = Cache::remember('tugas_siswa_detail_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\TugasSiswaDetail::with(['tugasSiswa'])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($tugasSiswaDetails->isEmpty()) {
            return $this->failedResponse('Tugas Siswa Detail not found');
        } else {
            return $this->successResponse('Tugas Siswa Detail retrieved successfully', $tugasSiswaDetails);
        }
    }

    public function show($id)
    {
        $tugasSiswaDetail = App\Models\Master\TugasSiswaDetail::with(['tugasSiswa'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($tugasSiswaDetail) {
            return $this->successResponse('Tugas Siswa Detail retrieved successfully', $tugasSiswaDetail);
        } else {
            return $this->failedResponse('Tugas Siswa Detail not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tugassiswa_id' => 'required|integer',
                'pertanyaan' => 'required|string',
                'pilihanjawaban' => 'required|string',
                'jawabanbenar' => 'required|string',
                'is_essay' => 'required|boolean',
                'jawaban_essay' => 'required|string',
            ]);

            $tugasSiswaDetail = App\Models\Master\TugasSiswaDetail::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'tugassiswa_id' => $validatedData['tugassiswa_id'],
                'pertanyaan' => $validatedData['pertanyaan'],
                'pilihanjawaban' => $validatedData['pilihanjawaban'],
                'jawabanbenar' => $validatedData['jawabanbenar'],
                'is_essay' => $validatedData['is_essay'],
                'jawaban_essay' => $validatedData['jawaban_essay'],
            ]);
            $log = $this->logActivity('Create', $request, json_encode($tugasSiswaDetail));
            return $this->successResponse('Tugas Siswa Detail created successfully', $tugasSiswaDetail);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa Detail failed to create');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tugasSiswaDetail = App\Models\Master\TugasSiswaDetail::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$tugasSiswaDetail) {
                return $this->failedResponse('Tugas Siswa Detail not found');
            }

            $validatedData = $request->validate([
                'tugassiswa_id' => 'required|integer',
                'pertanyaan' => 'required|string',
                'pilihanjawaban' => 'required|string',
                'jawabanbenar' => 'required|string',
                'is_essay' => 'required|boolean',
                'jawaban_essay' => 'required|string',
            ]);

            $tugasSiswaDetail->update([
                'tugassiswa_id' => $validatedData['tugassiswa_id'],
                'pertanyaan' => $validatedData['pertanyaan'],
                'pilihanjawaban' => $validatedData['pilihanjawaban'],
                'jawabanbenar' => $validatedData['jawabanbenar'],
                'is_essay' => $validatedData['is_essay'],
                'jawaban_essay' => $validatedData['jawaban_essay'],
            ]);
            $log = $this->logActivity('Update', $request, json_encode($tugasSiswaDetail));
            return $this->successResponse('Tugas Siswa Detail updated successfully', $tugasSiswaDetail);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa Detail failed to update');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $tugasSiswaDetail = App\Models\Master\TugasSiswaDetail::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$tugasSiswaDetail) {
                return $this->failedResponse('Tugas Siswa Detail not found');
            }

            $tugasSiswaDetail->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($tugasSiswaDetail));
            return $this->successResponse('Tugas Siswa Detail deleted successfully', $tugasSiswaDetail);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa Detail failed to delete');
        }
    }
}
