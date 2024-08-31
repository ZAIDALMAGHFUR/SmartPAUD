<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JenisKelaminController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jeniskelamins = App\Models\Master\JenisKelamin::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($jeniskelamins->isEmpty()) {
            return $this->failedResponse('Jenis Kelamin not found');
        } else {
            return $this->successResponse('Jenis Kelamin retrieved successfully', $jeniskelamins);
        }
    }

    public function show($id)
    {
        $jeniskelamin = App\Models\Master\JenisKelamin::find($id);

        if ($jeniskelamin) {
            return $this->successResponse('Jenis Kelamin retrieved successfully', $jeniskelamin);
        } else {
            return $this->failedResponse('Jenis Kelamin not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jeniskelamin = App\Models\Master\JenisKelamin::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jeniskelamin));
            return $this->successCreatedResponse('Jenis Kelamin created successfully', $jeniskelamin);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jeniskelamin = App\Models\Master\JenisKelamin::find($id);

            if ($jeniskelamin) {
                $jeniskelamin->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jeniskelamin));
                return $this->successResponse('Jenis Kelamin updated successfully', $jeniskelamin);
            } else {
                return $this->failedResponse('Jenis Kelamin not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jeniskelamin = App\Models\Master\JenisKelamin::find($id);

        if ($jeniskelamin) {
            $jeniskelamin->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jeniskelamin));
            return $this->successResponse('Jenis Kelamin deleted successfully', $jeniskelamin);
        } else {
            return $this->failedResponse('Jenis Kelamin not found');
        }
    }
}
