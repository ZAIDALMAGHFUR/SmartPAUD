<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class KelasSiswaController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $kelasSiswa = App\Models\Master\KelasSiswa::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->with(['siswa', 'tahunAjaran', 'kelas', 'waliKelas']) // Load related models
            ->get();

        if ($kelasSiswa->isEmpty()) {
            return $this->failedResponse('Kelas Siswa not found');
        } else {
            return $this->successResponse('Kelas Siswa retrieved successfully', $kelasSiswa);
        }
    }

    public function show($id)
    {
        $kelasSiswa = App\Models\Master\KelasSiswa::with(['siswa', 'tahunAjaran', 'kelas', 'waliKelas'])->find($id);

        if ($kelasSiswa) {
            return $this->successResponse('Kelas Siswa retrieved successfully', $kelasSiswa);
        } else {
            return $this->failedResponse('Kelas Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'siswa_id' => 'required',
                'tahunajaran_id' => 'required',
                'kelas_id' => 'required',
                'walikelas_id' => 'nullable',
            ]);

            $kelasSiswa = App\Models\Master\KelasSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'siswa_id' => $request->siswa_id,
                'tahunajaran_id' => $request->tahunajaran_id,
                'kelas_id' => $request->kelas_id,
                'walikelas_id' => $request->walikelas_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($kelasSiswa));
            return $this->successCreatedResponse('Kelas Siswa created successfully', $kelasSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'siswa_id' => 'required',
                'tahunajaran_id' => 'required',
                'kelas_id' => 'required',
                'walikelas_id' => 'nullable',
            ]);

            $kelasSiswa = App\Models\Master\KelasSiswa::find($id);

            if ($kelasSiswa) {
                $kelasSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'siswa_id' => $request->siswa_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                    'kelas_id' => $request->kelas_id,
                    'walikelas_id' => $request->walikelas_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($kelasSiswa));
                return $this->successResponse('Kelas Siswa updated successfully', $kelasSiswa);
            } else {
                return $this->failedResponse('Kelas Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $kelasSiswa = App\Models\Master\KelasSiswa::find($id);

        if ($kelasSiswa) {
            $kelasSiswa->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($kelasSiswa));
            return $this->successResponse('Kelas Siswa deleted successfully', $kelasSiswa);
        } else {
            return $this->failedResponse('Kelas Siswa not found');
        }
    }
}
