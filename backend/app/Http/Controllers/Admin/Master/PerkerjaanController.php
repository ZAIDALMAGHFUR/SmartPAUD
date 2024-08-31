<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class PerkerjaanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $pekerjaan = App\Models\Master\Pekerjaan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($pekerjaan->isEmpty()) {
            return $this->failedResponse('Pekerjaan not found');
        } else {
            return $this->successResponse('Pekerjaan retrieved successfully', $pekerjaan);
        }
    }

    public function show($id)
    {
        $pekerjaan = App\Models\Master\Pekerjaan::find($id);

        if ($pekerjaan) {
            return $this->successResponse('Pekerjaan retrieved successfully', $pekerjaan);
        } else {
            return $this->failedResponse('Pekerjaan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $pekerjaan = App\Models\Master\Pekerjaan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($pekerjaan));
            return $this->successCreatedResponse('Pekerjaan created successfully', $pekerjaan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pekerjaan = App\Models\Master\Pekerjaan::find($id);

            if ($pekerjaan) {
                $request->validate([
                    'name' => 'required',
                ]);

                $pekerjaan->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($pekerjaan));
                return $this->successResponse('Pekerjaan updated successfully', $pekerjaan);
            } else {
                return $this->failedResponse('Pekerjaan not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $pekerjaan = App\Models\Master\Pekerjaan::find($id);

        if ($pekerjaan) {
            $pekerjaan->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($pekerjaan));
            return $this->successResponse('Pekerjaan deleted successfully', $pekerjaan);
        } else {
            return $this->failedResponse('Pekerjaan not found');
        }
    }
}
