<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JadwalUjianController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jadwalUjian = App\Models\Master\JadwalUjian::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->with(['guru', 'kelas', 'mataPelajaran']) // Load related models
            ->get();

        if ($jadwalUjian->isEmpty()) {
            return $this->failedResponse('Jadwal Ujian not found');
        } else {
            return $this->successResponse('Jadwal Ujian retrieved successfully', $jadwalUjian);
        }
    }

    public function show($id)
    {
        $jadwalUjian = App\Models\Master\JadwalUjian::with(['guru', 'kelas', 'mataPelajaran'])->find($id);

        if ($jadwalUjian) {
            return $this->successResponse('Jadwal Ujian retrieved successfully', $jadwalUjian);
        } else {
            return $this->failedResponse('Jadwal Ujian not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tanggal_ujian' => 'required|date',
                'status_ujian' => 'required|in:aktif,nonaktif,draft',
                'started_at' => 'nullable|string',
                'ended_at' => 'nullable|string',
                'guru_id' => 'nullable',
                'kelas_id' => 'required',
                'matapelajaran_id' => 'required',
            ]);

            $jadwalUjian = App\Models\Master\JadwalUjian::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'tanggal_ujian' => $request->tanggal_ujian,
                'status_ujian' => $request->status_ujian,
                'started_at' => $request->started_at,
                'ended_at' => $request->ended_at,
                'guru_id' => $request->guru_id,
                'kelas_id' => $request->kelas_id,
                'matapelajaran_id' => $request->matapelajaran_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jadwalUjian));
            return $this->successCreatedResponse('Jadwal Ujian created successfully', $jadwalUjian);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal_ujian' => 'required|date',
                'status_ujian' => 'required|in:aktif,nonaktif,draft',
                'started_at' => 'nullable|string',
                'ended_at' => 'nullable|string',
                'guru_id' => 'nullable',
                'kelas_id' => 'required',
                'matapelajaran_id' => 'required',
            ]);

            $jadwalUjian = App\Models\Master\JadwalUjian::find($id);

            if ($jadwalUjian) {
                $jadwalUjian->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'tanggal_ujian' => $request->tanggal_ujian,
                    'status_ujian' => $request->status_ujian,
                    'started_at' => $request->started_at,
                    'ended_at' => $request->ended_at,
                    'guru_id' => $request->guru_id,
                    'kelas_id' => $request->kelas_id,
                    'matapelajaran_id' => $request->matapelajaran_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jadwalUjian));
                return $this->successResponse('Jadwal Ujian updated successfully', $jadwalUjian);
            } else {
                return $this->failedResponse('Jadwal Ujian not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jadwalUjian = App\Models\Master\JadwalUjian::find($id);

        if ($jadwalUjian) {
            $jadwalUjian->update([
                'statusenabled' => false,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jadwalUjian));
            return $this->successResponse('Jadwal Ujian deleted successfully', $jadwalUjian);
        } else {
            return $this->failedResponse('Jadwal Ujian not found');
        }
    }
}
