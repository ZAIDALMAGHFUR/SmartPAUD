<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class WargaNegaraController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $warganegaras = App\Models\Master\WargaNegara::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($warganegaras->isEmpty()) {
            return $this->failedResponse('Warga Negara not found');
        } else {
            return $this->successResponse('Warga Negara retrieved successfully', $warganegaras);
        }
    }

    public function show($id)
    {
        $warganegara = App\Models\Master\WargaNegara::find($id);

        if ($warganegara) {
            return $this->successResponse('Warga Negara retrieved successfully', $warganegara);
        } else {
            return $this->failedResponse('Warga Negara not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $warganegara = App\Models\Master\WargaNegara::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($warganegara));
            return $this->successCreatedResponse('Warga Negara created successfully', $warganegara);
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

            $warganegara = App\Models\Master\WargaNegara::find($id);
            $warganegara->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($warganegara));
            return $this->successResponse('Warga Negara updated successfully', $warganegara);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $warganegara = App\Models\Master\WargaNegara::find($id);

        if ($warganegara) {
            $warganegara->update([
                'statusenabled' => 0,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($warganegara));
            return $this->successResponse('Warga Negara deleted successfully', $warganegara);
        } else {
            return $this->failedResponse('Warga Negara not found');
        }
    }
}
