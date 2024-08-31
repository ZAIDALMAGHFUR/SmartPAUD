<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class GolonganDarahController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $golonganDarah = App\Models\Master\GolonganDarah::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($golonganDarah->isEmpty()) {
            return $this->failedResponse('Golongan Darah not found');
        } else {
            return $this->successResponse('Golongan Darah retrieved successfully', $golonganDarah);
        }
    }

    public function show($id)
    {
        $golonganDarah = App\Models\Master\GolonganDarah::find($id);

        if ($golonganDarah) {
            return $this->successResponse('Golongan Darah retrieved successfully', $golonganDarah);
        } else {
            return $this->failedResponse('Golongan Darah not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $golonganDarah = App\Models\Master\GolonganDarah::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($golonganDarah));
            return $this->successCreatedResponse('Golongan Darah created successfully', $golonganDarah);
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

            $golonganDarah = App\Models\Master\GolonganDarah::find($id);

            if ($golonganDarah) {
                $golonganDarah->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($golonganDarah));
                return $this->successResponse('Golongan Darah updated successfully', $golonganDarah);
            } else {
                return $this->failedResponse('Golongan Darah not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $golonganDarah = App\Models\Master\GolonganDarah::find($id);

        if ($golonganDarah) {
            $golonganDarah->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($golonganDarah));
            return $this->successResponse('Golongan Darah deleted successfully', $golonganDarah);
        } else {
            return $this->failedResponse('Golongan Darah not found');
        }
    }
}
