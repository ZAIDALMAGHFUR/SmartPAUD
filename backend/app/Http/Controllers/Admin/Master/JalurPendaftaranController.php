<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JalurPendaftaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jalurPendaftarans = App\Models\Master\JalurPendaftaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($jalurPendaftarans->isEmpty()) {
            return $this->failedResponse('Jalur Pendaftaran not found');
        } else {
            return $this->successResponse('Jalur Pendaftaran retrieved successfully', $jalurPendaftarans);
        }
    }

    public function show($id)
    {
        $jalurPendaftaran = App\Models\Master\JalurPendaftaran::find($id);

        if ($jalurPendaftaran) {
            return $this->successResponse('Jalur Pendaftaran retrieved successfully', $jalurPendaftaran);
        } else {
            return $this->failedResponse('Jalur Pendaftaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jalurPendaftaran = App\Models\Master\JalurPendaftaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jalurPendaftaran));
            return $this->successCreatedResponse('Jalur Pendaftaran created successfully', $jalurPendaftaran);
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

            $jalurPendaftaran = App\Models\Master\JalurPendaftaran::find($id);
            $jalurPendaftaran->update([
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jalurPendaftaran));
            return $this->successResponse('Jalur Pendaftaran updated successfully', $jalurPendaftaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jalurPendaftaran = App\Models\Master\JalurPendaftaran::find($id);

        if ($jalurPendaftaran) {
            $jalurPendaftaran->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jalurPendaftaran));
            return $this->successResponse('Jalur Pendaftaran deleted successfully', $jalurPendaftaran);
        } else {
            return $this->failedResponse('Jalur Pendaftaran not found');
        }
    }
}
