<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusMasukController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $StatusMasuk = App\Models\Master\StatusMasuk::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($StatusMasuk->isEmpty()) {
            return $this->failedResponse('Status Masuk Tidak Di Temukan');
        } else {
            return $this->successResponse('Status Masuk Berhasil Di Tampilkan', $StatusMasuk);
        }
    }

    public function show($id)
    {
        $StatusMasuk = App\Models\Master\StatusMasuk::find($id);

        if ($StatusMasuk) {
            return $this->successResponse('Status Masuk Berhasil Di Tampilkan', $StatusMasuk);
        } else {
            return $this->failedResponse('Status Masuk Tidak Di Temukan');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
            ]);

            $StatusMasuk = App\Models\Master\StatusMasuk::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($StatusMasuk));
            return $this->successCreatedResponse('Status Masuk Berhasil Di Buat', $StatusMasuk);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $StatusMasuk = App\Models\Master\StatusMasuk::find($id);

            if ($StatusMasuk) {
                $StatusMasuk->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'nama' => $request->nama,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($StatusMasuk));
                return $this->successResponse('Status Masuk Berhasil Di Perharui', $StatusMasuk);
            } else {
                return $this->failedResponse('Status Masuk Tidak Di Temukan');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $StatusMasuk = App\Models\Master\StatusMasuk::find($id);

        if ($StatusMasuk) {
            $StatusMasuk->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($StatusMasuk));
            return $this->successResponse('Status Masuk Berhasil Di Hapus', $StatusMasuk);
        } else {
            return $this->failedResponse('Status Masuk Tidak Di Temukan');
        }
    }
}
