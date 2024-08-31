<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $StatusSiswa = App\Models\Master\StatusSiswa::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($StatusSiswa->isEmpty()) {
            return $this->failedResponse('Status Siswa Tidak Di Temukan');
        } else {
            return $this->successResponse('Status Siswa Berhasil Di Tampilkan', $StatusSiswa);
        }
    }

    public function show($id)
    {
        $StatusSiswa = App\Models\Master\StatusSiswa::find($id);

        if ($StatusSiswa) {
            return $this->successResponse('Status Siswa Berhasil Di Tampilkan', $StatusSiswa);
        } else {
            return $this->failedResponse('Status Siswa Tidak Di Temukan');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
            ]);

            $StatusSiswa = App\Models\Master\StatusSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($StatusSiswa));
            return $this->successCreatedResponse('Status Siswa Berhasil Di Buat', $StatusSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $StatusSiswa = App\Models\Master\StatusSiswa::find($id);

            if ($StatusSiswa) {
                $StatusSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'nama' => $request->nama,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($StatusSiswa));
                return $this->successResponse('Status Siswa Berhasil Di Perharui', $StatusSiswa);
            } else {
                return $this->failedResponse('Status Siswa Tidak Di Temukan');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $StatusSiswa = App\Models\Master\StatusSiswa::find($id);

        if ($StatusSiswa) {
            $StatusSiswa->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($StatusSiswa));
            return $this->successResponse('Status Siswa Berhasil Di Hapus', $StatusSiswa);
        } else {
            return $this->failedResponse('Status Siswa Tidak Di Temukan');
        }
    }
}
