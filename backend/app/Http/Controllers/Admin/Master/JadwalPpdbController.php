<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\JadwalPpdb;
use Illuminate\Http\Request;
use App;

class JadwalPpdbController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jadwalPpdbs = JadwalPpdb::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($jadwalPpdbs->isEmpty()) {
            return $this->failedResponse('Jadwal PPDB not found');
        } else {
            return $this->successResponse('Jadwal PPDB retrieved successfully', $jadwalPpdbs);
        }
    }

    public function show($id)
    {
        $jadwalPpdb = JadwalPpdb::find($id);

        if ($jadwalPpdb) {
            return $this->successResponse('Jadwal PPDB retrieved successfully', $jadwalPpdb);
        } else {
            return $this->failedResponse('Jadwal PPDB not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'jeniskegiatan' => 'required',
                'tglmulai' => 'required|date',
                'tglakhir' => 'required|date',
                'tahunajaran_id' => 'required|exists:tahunajaran,id',
            ]);

            $jadwalPpdb = JadwalPpdb::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
                'jeniskegiatan' => $request->jeniskegiatan,
                'tglmulai' => $request->tglmulai,
                'tglakhir' => $request->tglakhir,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jadwalPpdb));
            return $this->successCreatedResponse('Jadwal PPDB created successfully', $jadwalPpdb);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'jeniskegiatan' => 'required',
                'tglmulai' => 'required|date',
                'tglakhir' => 'required|date',
                'tahunajaran_id' => 'required|exists:tahunajaran,id',
            ]);

            $jadwalPpdb = JadwalPpdb::find($id);
            $jadwalPpdb->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
                'jeniskegiatan' => $request->jeniskegiatan,
                'tglmulai' => $request->tglmulai,
                'tglakhir' => $request->tglakhir,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jadwalPpdb));
            return $this->successUpdatedResponse('Jadwal PPDB updated successfully', $jadwalPpdb);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jadwalPpdb = JadwalPpdb::find($id);

        if ($jadwalPpdb) {
            $jadwalPpdb->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jadwalPpdb));
            return $this->successDeletedResponse('Jadwal PPDB deleted successfully', $jadwalPpdb);
        } else {
            return $this->failedResponse('Jadwal PPDB not found');
        }
    }
}
