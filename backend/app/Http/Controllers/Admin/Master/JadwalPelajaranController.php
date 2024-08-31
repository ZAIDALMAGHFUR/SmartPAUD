<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JadwalPelajaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jadwalPelajarans = App\Models\Master\JadwalPelajaran::with(['kelas','mataPelajaran','guru','tahunAjaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($jadwalPelajarans->isEmpty()) {
            return $this->failedResponse('JadwalPelajaran not found');
        } else {
            return $this->successResponse('JadwalPelajaran retrieved successfully', $jadwalPelajarans);
        }
    }

    public function show($id)
    {
        $jadwalPelajaran = App\Models\Master\JadwalPelajaran::with(['kelas','mataPelajaran','guru','tahunAjaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($jadwalPelajaran) {
            return $this->successResponse('JadwalPelajaran retrieved successfully', $jadwalPelajaran);
        } else {
            return $this->failedResponse('JadwalPelajaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'hari' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'kelas_id' => 'required',
                'matapelajaran_id' => 'required',
                'guru_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $jadwalPelajaran = App\Models\Master\JadwalPelajaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'kelas_id' => $request->kelas_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'guru_id' => $request->guru_id,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jadwalPelajaran));
            return $this->successCreatedResponse('JadwalPelajaran created successfully', $jadwalPelajaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'hari' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'kelas_id' => 'required',
                'matapelajaran_id' => 'required',
                'guru_id' => 'required',
                'tahunajaran_id' => 'required',
            ]);

            $jadwalPelajaran = App\Models\Master\JadwalPelajaran::find($id);

            if ($jadwalPelajaran) {
                $jadwalPelajaran->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'hari' => $request->hari,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'kelas_id' => $request->kelas_id,
                    'matapelajaran_id' => $request->matapelajaran_id,
                    'guru_id' => $request->guru_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jadwalPelajaran));
                return $this->successResponse('JadwalPelajaran updated successfully', $jadwalPelajaran);
            } else {
                return $this->failedResponse('JadwalPelajaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $jadwalPelajaran = App\Models\Master\JadwalPelajaran::find($id);

            if ($jadwalPelajaran) {
                $jadwalPelajaran->update([
                    'statusenabled' => false,
                ]);

                $log = $this->logActivity('Delete', $request, json_encode($jadwalPelajaran));
                return $this->successResponse('JadwalPelajaran deleted successfully', $jadwalPelajaran);
            } else {
                return $this->failedResponse('JadwalPelajaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
