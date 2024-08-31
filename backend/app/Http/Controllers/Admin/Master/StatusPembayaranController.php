<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusPembayaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $statusPembayarans = App\Models\Master\StatusPembayaran::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($statusPembayarans->isEmpty()) {
            return $this->failedResponse('Status Pembayaran not found');
        } else {
            return $this->successResponse('Status Pembayaran retrieved successfully', $statusPembayarans);
        }
    }

    public function show($id)
    {
        $statusPembayaran = App\Models\Master\StatusPembayaran::find($id);

        if ($statusPembayaran) {
            return $this->successResponse('Status Pembayaran retrieved successfully', $statusPembayaran);
        } else {
            return $this->failedResponse('Status Pembayaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $statusPembayaran = App\Models\Master\StatusPembayaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusPembayaran));
            return $this->successCreatedResponse('Status Pembayaran created successfully', $statusPembayaran);
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

            $statusPembayaran = App\Models\Master\StatusPembayaran::find($id);

            if ($statusPembayaran) {
                $statusPembayaran->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($statusPembayaran));
                return $this->successResponse('Status Pembayaran updated successfully', $statusPembayaran);
            } else {
                return $this->failedResponse('Status Pembayaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $statusPembayaran = App\Models\Master\StatusPembayaran::find($id);

        if ($statusPembayaran) {
            $statusPembayaran->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($statusPembayaran));
            return $this->successResponse('Status Pembayaran deleted successfully');
        } else {
            return $this->failedResponse('Status Pembayaran not found');
        }
    }
}
