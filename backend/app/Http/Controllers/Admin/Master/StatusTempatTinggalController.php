<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class StatusTempatTinggalController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 100;
        $statusTempatTinggal = App\Models\Master\StatusTempatTinggal::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($statusTempatTinggal->isEmpty()) {
            return $this->failedResponse('Status Tempat Tinggal not found');
        } else {
            return $this->successResponse('Status Tempat Tinggal retrieved successfully', $statusTempatTinggal);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
            ]);

            $statusTempatTinggal = App\Models\Master\StatusTempatTinggal::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($statusTempatTinggal));
            return $this->successCreatedResponse('Status Tempat Tinggal created successfully', $statusTempatTinggal);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $statusTempatTinggal = App\Models\Master\StatusTempatTinggal::find($id);

        if ($statusTempatTinggal) {
            return $this->successResponse('Status Tempat Tinggal retrieved successfully', $statusTempatTinggal);
        } else {
            return $this->failedResponse('Status Tempat Tinggal not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required',
            ]);

            $statusTempatTinggal = App\Models\Master\StatusTempatTinggal::find($id);
            $statusTempatTinggal->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'nama' => $request->nama,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($statusTempatTinggal));
            return $this->successUpdatedResponse('Status Tempat Tinggal updated successfully', $statusTempatTinggal);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $statusTempatTinggal = App\Models\Master\StatusTempatTinggal::find($id);

        if ($statusTempatTinggal) {
            $statusTempatTinggal->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($statusTempatTinggal));
            return $this->successDeletedResponse('Status Tempat Tinggal deleted successfully', $statusTempatTinggal);
        } else {
            return $this->failedResponse('Status Tempat Tinggal not found');
        }
    }
}
