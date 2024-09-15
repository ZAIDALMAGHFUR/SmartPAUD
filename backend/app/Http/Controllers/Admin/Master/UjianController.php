<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class UjianController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $ujian = App\Models\Master\Ujian::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->with(['TahunAjaran', 'jadwalUjian']) // Load related models
            ->get();

        if ($ujian->isEmpty()) {
            return $this->failedResponse('Ujian not found');
        } else {
            return $this->successResponse('Ujian retrieved successfully', $ujian);
        }
    }

    public function show($id)
    {
        $ujian = App\Models\Master\Ujian::with(['tahunAjaran', 'jadwalUjian'])->find($id);

        if ($ujian) {
            return $this->successResponse('Ujian retrieved successfully', $ujian);
        } else {
            return $this->failedResponse('Ujian not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'durasi_ujian' => 'required',
                'tahunajaran_id' => 'required',
                'tipe_ujian' => 'required',
                'tipe_soal' => 'required',
            ]);

            $ujian = App\Models\Master\Ujian::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'durasi_ujian' => $request->durasi_ujian,
                'tahunajaran_id' => $request->tahunajaran_id,
                'tipe_ujian' => $request->tipe_ujian,
                'tipe_soal' => $request->tipe_soal,
                'random_soal' => $request->random_soal ?? '0',
                'lihat_hasil' => $request->lihat_hasil ?? '0',
                'jadwalujian_id' => $request->jadwalujian_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($ujian));
            return $this->successCreatedResponse('Ujian created successfully', $ujian);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'durasi_ujian' => 'required',
                'tahunajaran_id' => 'required',
                'tipe_ujian' => 'required',
                'tipe_soal' => 'required',
            ]);

            $ujian = App\Models\Master\Ujian::find($id);

            if ($ujian) {
                $ujian->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'durasi_ujian' => $request->durasi_ujian,
                    'tahunajaran_id' => $request->tahunajaran_id,
                    'tipe_ujian' => $request->tipe_ujian,
                    'tipe_soal' => $request->tipe_soal,
                    'random_soal' => $request->random_soal ?? '0',
                    'lihat_hasil' => $request->lihat_hasil ?? '0',
                    'jadwalujian_id' => $request->jadwalujian_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($ujian));
                return $this->successResponse('Ujian updated successfully', $ujian);
            } else {
                return $this->failedResponse('Ujian not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $ujian = App\Models\Master\Ujian::find($id);

        if ($ujian) {
            $ujian->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($ujian));
            return $this->successResponse('Ujian deleted successfully', $ujian);
        } else {
            return $this->failedResponse('Ujian not found');
        }
    }
}
