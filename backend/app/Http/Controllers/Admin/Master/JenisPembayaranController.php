<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JenisPembayaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jenisPembayarans = App\Models\Master\JenisPembayaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($jenisPembayarans->isEmpty()) {
            return $this->failedResponse('Jenis Pembayaran not found');
        } else {
            return $this->successResponse('Jenis Pembayaran retrieved successfully', $jenisPembayarans);
        }
    }

    public function show($id)
    {
        $jenisPembayaran = App\Models\Master\JenisPembayaran::find($id);

        if ($jenisPembayaran) {
            return $this->successResponse('Jenis Pembayaran retrieved successfully', $jenisPembayaran);
        } else {
            return $this->failedResponse('Jenis Pembayaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jenisPembayaran = App\Models\Master\JenisPembayaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jenisPembayaran));
            return $this->successCreatedResponse('Jenis Pembayaran created successfully', $jenisPembayaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jenisPembayaran = App\Models\Master\JenisPembayaran::find($id);
            $jenisPembayaran->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jenisPembayaran));
            return $this->successResponse('Jenis Pembayaran updated successfully', $jenisPembayaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jenisPembayaran = App\Models\Master\JenisPembayaran::find($id);

        if ($jenisPembayaran) {
            $jenisPembayaran->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jenisPembayaran));
            return $this->successResponse('Jenis Pembayaran deleted successfully', $jenisPembayaran);
        } else {
            return $this->failedResponse('Jenis Pembayaran not found');
        }
    }
}
