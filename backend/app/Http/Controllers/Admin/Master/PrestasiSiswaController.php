<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class PrestasiSiswaController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $prestasiSiswa = App\Models\Master\PrestasiSiswa::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($prestasiSiswa->isEmpty()) {
            return $this->failedResponse('Prestasi Siswa not found');
        } else {
            return $this->successResponse('Prestasi Siswa retrieved successfully', $prestasiSiswa);
        }
    }

    public function show($id)
    {
        $prestasiSiswa = App\Models\Master\PrestasiSiswa::find($id);

        if ($prestasiSiswa) {
            return $this->successResponse('Prestasi Siswa retrieved successfully', $prestasiSiswa);
        } else {
            return $this->failedResponse('Prestasi Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'siswa_id' => 'required',
                'jenisprestasi' => 'required',
                'namaprestasi' => 'required',
                'tingkatprestasi' => 'required',
                'peringkat' => 'required',
            ]);

            $prestasiSiswa = App\Models\Master\PrestasiSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'siswa_id' => $request->siswa_id,
                'jenisprestasi' => $request->jenisprestasi,
                'namaprestasi' => $request->namaprestasi,
                'tingkatprestasi' => $request->tingkatprestasi,
                'peringkat' => $request->peringkat,
                'penyelenggara' => $request->penyelenggara,
                'tanggalprestasi' => $request->tanggalprestasi,
                'dokumenprestasi' => $request->dokumenprestasi,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($prestasiSiswa));
            return $this->successCreatedResponse('Prestasi Siswa created successfully', $prestasiSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'siswa_id' => 'required',
                'jenisprestasi' => 'required',
                'namaprestasi' => 'required',
                'tingkatprestasi' => 'required',
                'peringkat' => 'required',
            ]);

            $prestasiSiswa = App\Models\Master\PrestasiSiswa::find($id);

            if ($prestasiSiswa) {
                $prestasiSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'siswa_id' => $request->siswa_id,
                    'jenisprestasi' => $request->jenisprestasi,
                    'namaprestasi' => $request->namaprestasi,
                    'tingkatprestasi' => $request->tingkatprestasi,
                    'peringkat' => $request->peringkat,
                    'penyelenggara' => $request->penyelenggara,
                    'tanggalprestasi' => $request->tanggalprestasi,
                    'dokumenprestasi' => $request->dokumenprestasi,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($prestasiSiswa));
                return $this->successResponse('Prestasi Siswa updated successfully', $prestasiSiswa);
            } else {
                return $this->failedResponse('Prestasi Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $prestasiSiswa = App\Models\Master\PrestasiSiswa::find($id);

        if ($prestasiSiswa) {
            $prestasiSiswa->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($prestasiSiswa));
            return $this->successResponse('Prestasi Siswa deleted successfully', $prestasiSiswa);
        } else {
            return $this->failedResponse('Prestasi Siswa not found');
        }
    }
}
