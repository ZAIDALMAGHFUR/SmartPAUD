<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class ShiftKerjaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $shiftKerjas = App\Models\Master\ShiftKerja::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($shiftKerjas->isEmpty()) {
            return $this->failedResponse('Shift Kerja not found');
        } else {
            return $this->successResponse('Shift Kerja retrieved successfully', $shiftKerjas);
        }
    }

    public function show($id)
    {
        $shiftKerja = App\Models\Master\ShiftKerja::find($id);

        if ($shiftKerja) {
            return $this->successResponse('Shift Kerja retrieved successfully', $shiftKerja);
        } else {
            return $this->failedResponse('Shift Kerja not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'jammasuk' => 'required',
                'jampulang' => 'required',
            ]);

            $shiftKerja = App\Models\Master\ShiftKerja::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
                'jammasuk' => $request->jammasuk,
                'jampulang' => $request->jampulang,
                'jambreakawal' => $request->jambreakawal,
                'jambreakakhir' => $request->jambreakakhir,
                'factorrate' => $request->factorrate,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($shiftKerja));
            return $this->successCreatedResponse('Shift Kerja created successfully', $shiftKerja);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $shiftKerja = App\Models\Master\ShiftKerja::find($id);

            if ($shiftKerja) {
                $shiftKerja->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'name' => $request->name,
                    'jammasuk' => $request->jammasuk,
                    'jampulang' => $request->jampulang,
                    'jambreakawal' => $request->jambreakawal,
                    'jambreakakhir' => $request->jambreakakhir,
                    'factorrate' => $request->factorrate,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($shiftKerja));
                return $this->successResponse('Shift Kerja updated successfully', $shiftKerja);
            } else {
                return $this->failedResponse('Shift Kerja not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $shiftKerja = App\Models\Master\ShiftKerja::find($id);

        if ($shiftKerja) {
            $shiftKerja->update([
                'statusenabled' => false,
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($shiftKerja));
            return $this->successResponse('Shift Kerja deleted successfully', $shiftKerja);
        } else {
            return $this->failedResponse('Shift Kerja not found');
        }
    }
}
