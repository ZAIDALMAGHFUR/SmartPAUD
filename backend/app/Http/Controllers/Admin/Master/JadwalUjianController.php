<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JadwalUjianController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jadwalUjians = App\Models\Master\JadwalUjian::with(['guru','matapelajaran','kelas','tahunajaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($jadwalUjians->isEmpty()) {
            return $this->failedResponse('JadwalUjian not found');
        } else {
            return $this->successResponse('JadwalUjian retrieved successfully', $jadwalUjians);
        }
    }

    public function show($id)
    {
        $jadwalUjian = App\Models\Master\JadwalUjian::with(['guru','matapelajaran','kelas','tahunajaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($jadwalUjian) {
            return $this->successResponse('JadwalUjian retrieved successfully', $jadwalUjian);
        } else {
            return $this->failedResponse('JadwalUjian not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal_ujian' => 'required',
                'status_ujian' => 'required',
                'started_at' => 'required',
                'ended_at' => 'required',
                'guru_can_manage' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $jadwalUjian = App\Models\Master\JadwalUjian::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'tanggal_ujian' => $request->tanggal_ujian,
                'status_ujian' => $request->status_ujian,
                'started_at' => $request->started_at,
                'ended_at' => $request->ended_at,
                'guru_can_manage' => $request->guru_can_manage,
                'guru_id' => $request->guru_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);
            $log = $this->logActivity('Create', $request, json_encode($jadwalUjian));
            return $this->successResponse('JadwalUjian created successfully', $jadwalUjian);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_ujian' => 'required',
                'status_ujian' => 'required',
                'started_at' => 'required',
                'ended_at' => 'required',
                'guru_can_manage' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $jadwalUjian = App\Models\Master\JadwalUjian::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if ($jadwalUjian) {
                $jadwalUjian->update([
                    'tanggal_ujian' => $request->tanggal_ujian,
                    'status_ujian' => $request->status_ujian,
                    'started_at' => $request->started_at,
                    'ended_at' => $request->ended_at,
                    'guru_can_manage' => $request->guru_can_manage,
                    'guru_id' => $request->guru_id,
                    'matapelajaran_id' => $request->matapelajaran_id,
                    'kelas_id' => $request->kelas_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                ]);
                $log = $this->logActivity('Update', $request, json_encode($jadwalUjian));
                return $this->successResponse('JadwalUjian updated successfully', $jadwalUjian);
            } else {
                return $this->failedResponse('JadwalUjian not found');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $jadwalUjian = App\Models\Master\JadwalUjian::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if ($jadwalUjian) {
                $jadwalUjian->update([
                    'statusenabled' => 0,
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($jadwalUjian));
                return $this->successResponse('JadwalUjian deleted successfully', $jadwalUjian);
            } else {
                return $this->failedResponse('JadwalUjian not found');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
