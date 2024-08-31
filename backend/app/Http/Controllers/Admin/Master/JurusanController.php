<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JurusanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jurusans = App\Models\Master\Jurusan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($jurusans->isEmpty()) {
            return $this->failedResponse('Jurusan not found');
        } else {
            return $this->successResponse('Jurusan retrieved successfully', $jurusans);
        }
    }

    public function show($id)
    {
        $jurusan = App\Models\Master\Jurusan::find($id);

        if ($jurusan) {
            return $this->successResponse('Jurusan retrieved successfully', $jurusan);
        } else {
            return $this->failedResponse('Jurusan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jurusan = App\Models\Master\Jurusan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jurusan));
            return $this->successCreatedResponse('Jurusan created successfully', $jurusan);
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

            $jurusan = App\Models\Master\Jurusan::find($id);
            $jurusan->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jurusan));
            return $this->successResponse('Jurusan updated successfully', $jurusan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jurusan = App\Models\Master\Jurusan::find($id);

        if ($jurusan) {
            $jurusan->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jurusan));
            return $this->successResponse('Jurusan deleted successfully', $jurusan);
        } else {
            return $this->failedResponse('Jurusan not found');
        }
    }
}
