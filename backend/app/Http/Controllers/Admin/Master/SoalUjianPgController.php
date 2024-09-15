<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class SoalUjianPgController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;


    public function index()
    {
        $soal = App\Models\Master\SoalUjianPG::where('statusenabled', true)
            ->where('kdprofile', $this->kdprofile())
            ->with(['ujian'])
            ->get();

        if ($soal->isEmpty()) {
            return $this->failedResponse('Soal Ujian PG not found');
        } else {
            return $this->successResponse('Soal Ujian PG retrieved successfully', $soal);
        }
    }

    public function show($id)
    {
        $soal = App\Models\Master\SoalUjianPG::with(['ujian'])->find($id);

        if ($soal) {
            return $this->successResponse('Soal Ujian PG retrieved successfully', $soal);
        } else {
            return $this->failedResponse('Soal Ujian PG not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomor_soal' => 'required',
                'pertanyaan' => 'required',
                'pilihan_a' => 'required',
                'pilihan_b' => 'required',
                'pilihan_c' => 'required',
                'pilihan_d' => 'required',
                'jawaban_benar' => 'required',
                'ujian_id' => 'required',
            ]);

            $soal = App\Models\Master\SoalUjianPG::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nomor_soal' => $request->nomor_soal,
                'pertanyaan' => $request->pertanyaan,
                'pilihan_a' => $request->pilihan_a,
                'pilihan_b' => $request->pilihan_b,
                'pilihan_c' => $request->pilihan_c,
                'pilihan_d' => $request->pilihan_d,
                'pilihan_e' => $request->pilihan_e,
                'jawaban_benar' => $request->jawaban_benar,
                'ujian_id' => $request->ujian_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($soal));
            return $this->successCreatedResponse('Soal Ujian PG created successfully', $soal);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nomor_soal' => 'required',
                'pertanyaan' => 'required',
                'pilihan_a' => 'required',
                'pilihan_b' => 'required',
                'pilihan_c' => 'required',
                'pilihan_d' => 'required',
                'jawaban_benar' => 'required',
                'ujian_id' => 'required',
            ]);

            $soal = App\Models\Master\SoalUjianPG::find($id);

            if ($soal) {
                $soal->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'nomor_soal' => $request->nomor_soal,
                    'pertanyaan' => $request->pertanyaan,
                    'pilihan_a' => $request->pilihan_a,
                    'pilihan_b' => $request->pilihan_b,
                    'pilihan_c' => $request->pilihan_c,
                    'pilihan_d' => $request->pilihan_d,
                    'pilihan_e' => $request->pilihan_e,
                    'jawaban_benar' => $request->jawaban_benar,
                    'ujian_id' => $request->ujian_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($soal));
                return $this->successResponse('Soal Ujian PG updated successfully', $soal);
            } else {
                return $this->failedResponse('Soal Ujian PG not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $soal = App\Models\Master\SoalUjianPG::find($id);

        if ($soal) {
            $soal->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($soal));
            return $this->successResponse('Soal Ujian PG deleted successfully', $soal);
        } else {
            return $this->failedResponse('Soal Ujian PG not found');
        }
    }
}
