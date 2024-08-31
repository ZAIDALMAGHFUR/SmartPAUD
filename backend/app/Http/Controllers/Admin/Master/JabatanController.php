<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JabatanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $jabatans = App\Models\Master\Jabatan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($jabatans->isEmpty()) {
            return $this->failedResponse('Jabatan not found');
        } else {
            return $this->successResponse('Jabatan retrieved successfully', $jabatans);
        }
    }

    public function show($id)
    {
        $jabatan = App\Models\Master\Jabatan::find($id);

        if ($jabatan) {
            return $this->successResponse('Jabatan retrieved successfully', $jabatan);
        } else {
            return $this->failedResponse('Jabatan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jabatan = App\Models\Master\Jabatan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jabatan));
            return $this->successCreatedResponse('Jabatan created successfully', $jabatan);
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

            $jabatan = App\Models\Master\Jabatan::find($id);

            if ($jabatan) {
                $jabatan->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($jabatan));
                return $this->successResponse('Jabatan updated successfully', $jabatan);
            } else {
                return $this->failedResponse('Jabatan not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jabatan = App\Models\Master\Jabatan::find($id);

        if ($jabatan) {
            $jabatan->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($jabatan));
            return $this->successResponse('Jabatan deleted successfully', $jabatan);
        } else {
            return $this->failedResponse('Jabatan not found');
        }
    }
}
