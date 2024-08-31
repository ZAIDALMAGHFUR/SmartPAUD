<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class RolesController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $roles = App\Models\Roles::where('statusenabled', 1)->get();

        if ($roles->isEmpty()) {
            return $this->failedResponse('Roles not found');
        } else {
            return $this->successResponse('Roles retrieved successfully', $roles);
        }
    }

    public function show($id)
    {
        $roles = App\Models\Roles::find($id);

        if (!$roles) {
            return $this->failedResponse('Roles not found');
        } else {
            return $this->successResponse('Roles retrieved successfully', $roles);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $roles = App\Models\Roles::create([
                'kdprofile' => $this->kdProfile(),
                'statusenabled' => $request->statusenabled,
                'name' => $request->name,
            ]);
            $log = $this->logActivity('make a new roles', $request, json_encode($roles));
            return $this->successCreatedResponse('Roles created successfully', $roles);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $roles = App\Models\Roles::find($id);

            if (!$roles) {
                return $this->failedResponse('Roles not found');
            }

            $roles->update([
                'name' => $request->name,
            ]);

            $log = $this->logActivity('update roles', $request, json_encode($roles));
            return $this->successResponse('Roles updated successfully', $roles);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $roles = App\Models\Roles::find($id);

        if (!$roles) {
            return $this->failedResponse('Roles not found');
        }

        $roles->update([
            'statusenabled' => 0,
        ]);

        $log = $this->logActivity('delete roles', $request, json_encode($roles));
        return $this->successResponse('Roles deleted successfully', $roles);
    }
}
