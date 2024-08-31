<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App;

class EkstrakurikulerController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ekstrakurikulers = Cache::remember('ekstrakurikuler_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\Ekstrakurikuler::where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($ekstrakurikulers->isEmpty()) {
            return $this->failedResponse('Ekstrakurikuler not found');
        } else {
            return $this->successResponse('Ekstrakurikuler retrieved successfully', $ekstrakurikulers);
        }
    }

    public function show($id)
    {
        $ekstrakurikuler = App\Models\Master\Ekstrakurikuler::find($id);

        if ($ekstrakurikuler->isEmpty()) {
            return $this->failedResponse('Ekstrakurikuler not found');
        } else {
            return $this->successResponse('Ekstrakurikuler retrieved successfully', $ekstrakurikuler);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $ekstrakurikuler = App\Models\Master\Ekstrakurikuler::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);
            $log = $this->logActivity('Create', $request, json_encode($ekstrakurikuler));
            return $this->successResponse('Ekstrakurikuler created successfully', $ekstrakurikuler);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $ekstrakurikuler = App\Models\Master\Ekstrakurikuler::find($id);
            $ekstrakurikuler->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);
            $log = $this->logActivity('Update', $request, json_encode($ekstrakurikuler));
            return $this->successResponse('Ekstrakurikuler updated successfully', $ekstrakurikuler);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ekstrakurikuler = App\Models\Master\Ekstrakurikuler::find($id);
            $ekstrakurikuler->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($ekstrakurikuler));
            return $this->successResponse('Ekstrakurikuler deleted successfully', $ekstrakurikuler);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
