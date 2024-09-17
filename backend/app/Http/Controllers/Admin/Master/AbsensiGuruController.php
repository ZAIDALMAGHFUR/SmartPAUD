<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App;

class AbsensiGuruController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $absens = Cache::remember('absen_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\AbsensiGuru::with([
                'siswatransaksi',
                'guru',
                'matapelajaran',
                'kelas',
                'tahunajaran',
            ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);
        });

        if ($absens->isEmpty()) {
            return $this->failedResponse('Absen not found');
        } else {
            return $this->successResponse('Absen retrieved successfully', $absens);
        }
    }

    public function show($id)
    {
        $absen = App\Models\Master\AbsensiGuru::with([
            'siswatransaksi',
            'guru',
            'matapelajaran',
            'kelas',
            'tahunajaran',
        ])
        ->where('id', $id)
        ->where('statusenabled', $this->statusEnabled())
        ->where('kdprofile', $this->kdprofile())
        ->first();

        if ($absen === null) {
            return $this->failedResponse('Absen not found');
        } else {
            return $this->successResponse('Absen retrieved successfully', $absen);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'status' => 'required',
                'rangkuman' => 'required',
                'beritaacara' => 'nullable',
                'kelassiswa_id' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $absen = App\Models\Master\AbsensiGuru::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'status' => $request->status,
                'rangkuman' => $request->rangkuman,
                'beritaacara' => $request->beritaacara,
                'kelassiswa_id' => $request->kelassiswa_id,
                'guru_id' => $request->guru_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($absen));
            return $this->successCreatedResponse('Absen created successfully', $absen);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required',
                'rangkuman' => 'required',
                'beritaacara' => 'nullable',
                'kelassiswa_id' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $absen = App\Models\Master\AbsensiGuru::where('id', $id)
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->first();

            if ($absen === null) {
                return $this->failedResponse('Absen not found');
            } else {
                $absen->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'status' => $request->status,
                    'rangkuman' => $request->rangkuman,
                    'beritaacara' => $request->beritaacara,
                    'kelassiswa_id' => $request->kelassiswa_id,
                    'guru_id' => $request->guru_id,
                    'matapelajaran_id' => $request->matapelajaran_id,
                    'kelas_id' => $request->kelas_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($absen));
                return $this->successUpdatedResponse('Absen updated successfully', $absen);
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $absen = App\Models\Master\AbsensiGuru::where('id', $id)
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->first();

            if ($absen === null) {
                return $this->failedResponse('Absen not found');
            } else {
                $absen->update([
                    'statusenabled' => 0,
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($absen));
                return $this->successDeletedResponse('Absen deleted successfully', $absen);
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
