<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class PendidikanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $pendidikans = App\Models\Master\Pendidikan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($pendidikans->isEmpty()) {
            return $this->failedResponse('Pendidikan not found');
        } else {
            return $this->successResponse('Pendidikan retrieved successfully', $pendidikans);
        }
    }

    public function show($id)
    {
        $pendidikan = App\Models\Master\Pendidikan::find($id);

        if ($pendidikan) {
            return $this->successResponse('Pendidikan retrieved successfully', $pendidikan);
        } else {
            return $this->failedResponse('Pendidikan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $pendidikan = App\Models\Master\Pendidikan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($pendidikan));
            return $this->successCreatedResponse('Pendidikan created successfully', $pendidikan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pendidikan = App\Models\Master\Pendidikan::find($id);

            if ($pendidikan) {
                $request->validate([
                    'name' => 'required',
                ]);

                $pendidikan->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($pendidikan));
                return $this->successResponse('Pendidikan updated successfully', $pendidikan);
            } else {
                return $this->failedResponse('Pendidikan not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $pendidikan = App\Models\Master\Pendidikan::find($id);

        if ($pendidikan) {
            $pendidikan->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($pendidikan));
            return $this->successResponse('Pendidikan deleted successfully', $pendidikan);
        } else {
            return $this->failedResponse('Pendidikan not found');
        }
    }
}
