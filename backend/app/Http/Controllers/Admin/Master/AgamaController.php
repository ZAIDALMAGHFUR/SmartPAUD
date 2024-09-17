<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class AgamaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $agamas = App\Models\Master\Agama::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($agamas->isEmpty()) {
            return $this->failedResponse('Agama not found');
        } else {
            return $this->successResponse('Agama retrieved successfully', $agamas);
        }
    }

    public function show($id)
    {
        $agama = App\Models\Master\Agama::find($id);

        if ($agama) {
            return $this->successResponse('Agama retrieved successfully', $agama);
        } else {
            return $this->failedResponse('Agama not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $agama = App\Models\Master\Agama::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($agama));
            return $this->successCreatedResponse('Agama created successfully', $agama);
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

            $agama = App\Models\Master\Agama::find($id);

            if ($agama) {
                $agama->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($agama));
                return $this->successResponse('Agama updated successfully', $agama);
            } else {
                return $this->failedResponse('Agama not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $agama = App\Models\Master\Agama::find($id);

        if ($agama) {
            $agama->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($agama));
            return $this->successResponse('Agama deleted successfully', $agama);
        } else {
            return $this->failedResponse('Agama not found');
        }
    }
}
