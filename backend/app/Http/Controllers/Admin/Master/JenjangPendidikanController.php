<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class JenjangPendidikanController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jenjangPendidikans = App\Models\Master\JenjangPendidikan::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($jenjangPendidikans->isEmpty()) {
            return $this->failedResponse('Jenjang Pendidikan not found');
        } else {
            return $this->successResponse('Jenjang Pendidikan retrieved successfully', $jenjangPendidikans);
        }
    }

    public function show($id)
    {
        $jenjangPendidikan = App\Models\Master\JenjangPendidikan::find($id);

        if ($jenjangPendidikan) {
            return $this->successResponse('Jenjang Pendidikan retrieved successfully', $jenjangPendidikan);
        } else {
            return $this->failedResponse('Jenjang Pendidikan not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $jenjangPendidikan = App\Models\Master\JenjangPendidikan::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jenjangPendidikan));
            return $this->successCreatedResponse('Jenjang Pendidikan created successfully', $jenjangPendidikan);
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

            $jenjangPendidikan = App\Models\Master\JenjangPendidikan::find($id);
            $jenjangPendidikan->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jenjangPendidikan));
            return $this->successResponse('Jenjang Pendidikan updated successfully', $jenjangPendidikan);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $jenjangPendidikan = App\Models\Master\JenjangPendidikan::find($id);

        if ($jenjangPendidikan) {
            $jenjangPendidikan->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jenjangPendidikan));
            return $this->successResponse('Jenjang Pendidikan deleted successfully');
        } else {
            return $this->failedResponse('Jenjang Pendidikan not found');
        }
    }
}
