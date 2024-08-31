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
        $StatusPendaftarans = App\Models\Master\StatusPendaftaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($StatusPendaftarans->isEmpty()) {
            return $this->failedResponse('Satus Pendaftaran not found');
        } else {
            return $this->successResponse('Satus Pendaftaran retrieved successfully', $StatusPendaftarans);
        }
    }

    public function show($id)
    {
        $StatusPendaftaran = App\Models\Master\StatusPendaftaran::find($id);

        if ($StatusPendaftaran) {
            return $this->successResponse('Satus Pendaftaran retrieved successfully', $StatusPendaftaran);
        } else {
            return $this->failedResponse('Satus Pendaftaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $StatusPendaftaran = App\Models\Master\StatusPendaftaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($StatusPendaftaran));
            return $this->successCreatedResponse('Satus Pendaftaran created successfully', $StatusPendaftaran);
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

            $StatusPendaftaran = App\Models\Master\StatusPendaftaran::find($id);
            $StatusPendaftaran->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($StatusPendaftaran));
            return $this->successResponse('Satus Pendaftaran updated successfully', $StatusPendaftaran);
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
            return $this->successResponse('Satus Pendaftaran deleted successfully', $StatusPendaftaran);
        } else {
            return $this->failedResponse('Satus Pendaftaran not found');
        }
    }
}
