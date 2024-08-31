<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App;

class JawabanTugasSiswaDetailController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jawabanTugasSiswaDetails = Cache::remember('jawaban_tugas_siswa_detail_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\JawabanTugasSiswaDetail::with(['jawabanTugasSiswa', 'tugasSiswaDetail'])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($jawabanTugasSiswaDetails->isEmpty()) {
            return $this->failedResponse('Jawaban Tugas Siswa Detail not found');
        } else {
            return $this->successResponse('Jawaban Tugas Siswa Detail retrieved successfully', $jawabanTugasSiswaDetails);
        }
    }

    public function show($id)
    {
        $jawabanTugasSiswaDetail = App\Models\Master\JawabanTugasSiswaDetail::with(['jawabanTugasSiswa', 'tugasSiswaDetail'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($jawabanTugasSiswaDetail) {
            return $this->successResponse('Jawaban Tugas Siswa Detail retrieved successfully', $jawabanTugasSiswaDetail);
        } else {
            return $this->failedResponse('Jawaban Tugas Siswa Detail not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'jawabantugassiswa_id' => 'required|integer',
                'tugassiswadetail_id' => 'required|integer',
                'jawabanpilihan' => 'required|string',
                'jawabanessay' => 'required|string',
                'iscorrect' => 'required|boolean',
            ]);

            $jawabanTugasSiswaDetail = App\Models\Master\JawabanTugasSiswaDetail::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'jawabantugassiswa_id' => $validatedData['jawabantugassiswa_id'],
                'tugassiswadetail_id' => $validatedData['tugassiswadetail_id'],
                'jawabanpilihan' => $validatedData['jawabanpilihan'],
                'jawabanessay' => $validatedData['jawabanessay'],
                'iscorrect' => $validatedData['iscorrect'],
                'nilai' => $request->nilai,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jawabanTugasSiswaDetail));
            return $this->successResponse('Jawaban Tugas Siswa Detail stored successfully', $jawabanTugasSiswaDetail);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jawabanTugasSiswaDetail = App\Models\Master\JawabanTugasSiswaDetail::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if ($jawabanTugasSiswaDetail) {
                $validatedData = $request->validate([
                    'jawabantugassiswa_id' => 'required|integer',
                    'tugassiswadetail_id' => 'required|integer',
                    'jawabanpilihan' => 'required|string',
                    'jawabanessay' => 'required|string',
                    'iscorrect' => 'required|boolean',
                ]);

                $jawabanTugasSiswaDetail->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'jawabantugassiswa_id' => $validatedData['jawabantugassiswa_id'],
                    'tugassiswadetail_id' => $validatedData['tugassiswadetail_id'],
                    'jawabanpilihan' => $validatedData['jawabanpilihan'],
                    'jawabanessay' => $validatedData['jawabanessay'],
                    'iscorrect' => $validatedData['iscorrect'],
                    'nilai' => $request->nilai,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jawabanTugasSiswaDetail));
                return $this->successResponse('Jawaban Tugas Siswa Detail updated successfully', $jawabanTugasSiswaDetail);
            } else {
                return $this->failedResponse('Jawaban Tugas Siswa Detail not found');
            }
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jawabanTugasSiswaDetail = App\Models\Master\JawabanTugasSiswaDetail::where('kdprofile', $this->kdprofile())
            ->where('statusenabled', $this->statusEnabled())
            ->find($id);

        if ($jawabanTugasSiswaDetail) {
            $jawabanTugasSiswaDetail->update([
                'statusenabled' => false,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($jawabanTugasSiswaDetail));
            return $this->successResponse('Jawaban Tugas Siswa Detail deleted successfully');
        } else {
            return $this->failedResponse('Jawaban Tugas Siswa Detail not found');
        }
    }
}
