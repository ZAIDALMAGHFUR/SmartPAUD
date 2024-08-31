<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusPerkawinanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $statusperkawinans = App\Models\Master\StatusPerkawinan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($statusperkawinans->isEmpty()) {
            return $this->failedResponse('Status Perkawinan not found');
        } else {
            return $this->successResponse('Status Perkawinan retrieved successfully', $statusperkawinans);
        }
    }

    public function show($id)
    {
        $statusperkawinan = App\Models\Master\StatusPerkawinan::find($id);

        if ($statusperkawinan) {
            return $this->successResponse('Status Perkawinan retrieved successfully', $statusperkawinan);
        } else {
            return $this->failedResponse('Status Perkawinan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $statusperkawinan = App\Models\Master\StatusPerkawinan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusperkawinan));
            return $this->successCreatedResponse('Status Perkawinan created successfully', $statusperkawinan);
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

            $statusperkawinan = App\Models\Master\StatusPerkawinan::find($id);
            $statusperkawinan->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($statusperkawinan));
            return $this->successResponse('Status Perkawinan updated successfully', $statusperkawinan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $statusperkawinan = App\Models\Master\StatusPerkawinan::find($id);
            $statusperkawinan->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($statusperkawinan));
            return $this->successResponse('Status Perkawinan deleted successfully', $statusperkawinan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
