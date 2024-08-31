<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusPendaftaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $StatusPendaftaran = App\Models\Master\StatusPendaftaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($StatusPendaftaran->isEmpty()) {
            return $this->failedResponse('Status Pendaftaran Tidak Di Temukan');
        } else {
            return $this->successResponse('Status Pendaftaran Berhasil Di Tampilkan', $StatusPendaftaran);
        }
    }

    public function show($id)
    {
        $StatusPendaftaran = App\Models\Master\StatusPendaftaran::find($id);

        if ($StatusPendaftaran) {
            return $this->successResponse('Status Pendaftaran Berhasil Di Tampilkan', $StatusPendaftaran);
        } else {
            return $this->failedResponse('Status Pendaftaran Tidak Di Temukan');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
            ]);

            $StatusPendaftaran = App\Models\Master\StatusPendaftaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($StatusPendaftaran));
            return $this->successCreatedResponse('Status Pendaftaran Berhasil Di Buat', $StatusPendaftaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $StatusPendaftaran = App\Models\Master\StatusPendaftaran::find($id);

            if ($StatusPendaftaran) {
                $StatusPendaftaran->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'nama' => $request->nama,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($StatusPendaftaran));
                return $this->successResponse('Status Pendaftaran Berhasil Di Perharui', $StatusPendaftaran);
            } else {
                return $this->failedResponse('Status Pendaftaran Tidak Di Temukan');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $StatusPendaftaran = App\Models\Master\StatusPendaftaran::find($id);

        if ($StatusPendaftaran) {
            $StatusPendaftaran->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($StatusPendaftaran));
            return $this->successResponse('Status Pendaftaran Berhasil Di Hapus', $StatusPendaftaran);
        } else {
            return $this->failedResponse('Status Pendaftaran Tidak Di Temukan');
        }
    }
}
