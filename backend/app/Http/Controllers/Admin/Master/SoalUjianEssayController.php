<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class SoalUjianEssayController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $soalUjianEssays = App\Models\Master\SoalUjianEssay::with('ujian')
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($soalUjianEssays->isEmpty()) {
            return $this->failedResponse('SoalUjianEssay not found');
        } else {
            return $this->successResponse('SoalUjianEssay retrieved successfully', $soalUjianEssays);
        }
    }

    public function show($id)
    {
        $soalUjianEssay = App\Models\Master\SoalUjianEssay::with('ujian')
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($soalUjianEssay) {
            return $this->successResponse('SoalUjianEssay retrieved successfully', $soalUjianEssay);
        } else {
            return $this->failedResponse('SoalUjianEssay not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomor_soal' => 'required',
                'pertanyaan' => 'required',
                'ujian_id' => 'required',
            ]);

            $soalUjianEssay =App\Models\Master\SoalUjianEssay::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nomor_soal' => $request->nomor_soal,
                'pertanyaan' => $request->pertanyaan,
                'ujian_id' => $request->ujian_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($soalUjianEssay));
            return $this->successCreatedResponse('SoalUjianEssay created successfully', $soalUjianEssay);
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
                'ujian_id' => 'required',
            ]);

            $soalUjianEssay = App\Models\Master\SoalUjianEssay::find($id);

            if ($soalUjianEssay) {
                $soalUjianEssay->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'nomor_soal' => $request->nomor_soal,
                    'pertanyaan' => $request->pertanyaan,
                    'ujian_id' => $request->ujian_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($soalUjianEssay));
                return $this->successResponse('SoalUjianEssay updated successfully', $soalUjianEssay);
            } else {
                return $this->failedResponse('SoalUjianEssay not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $soalUjianEssay = App\Models\Master\SoalUjianEssay::find($id);

            if ($soalUjianEssay) {
                $soalUjianEssay->update([
                    'statusenabled' => false,
                ]);

                $log = $this->logActivity('Delete', $request, json_encode($soalUjianEssay));
                return $this->successResponse('SoalUjianEssay deleted successfully', $soalUjianEssay);
            } else {
                return $this->failedResponse('SoalUjianEssay not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
