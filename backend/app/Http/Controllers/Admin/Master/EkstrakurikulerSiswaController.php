<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class EkstrakurikulerSiswaController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ekstrakurikulerSiswa = Cache::remember('ekstrakurikuler_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\EkstrakurikulerSiswa::with([
                'KelasSiswa',
                'guru',
                'ekstrakurikuler'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($ekstrakurikulerSiswa->isEmpty()) {
            return $this->failedResponse('Ekstrakurikuler Siswa not found');
        } else {
            return $this->successResponse('Ekstrakurikuler Siswa retrieved successfully', $ekstrakurikulerSiswa);
        }
    }

    public function show($id)
    {
        $ekstrakurikulerSiswa = App\Models\Master\EkstrakurikulerSiswa::with([
            'KelasSiswa',
            'guru',
            'ekstrakurikuler'
        ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($ekstrakurikulerSiswa) {
            return $this->successResponse('Ekstrakurikuler Siswa retrieved successfully', $ekstrakurikulerSiswa);
        } else {
            return $this->failedResponse('Ekstrakurikuler Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'kelassiswa_id' => 'required',
                'guru_id' => 'required',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'nullable|date',
                'keterangan' => 'nullable|string',
                'ekstrakurikuler_id' => 'required'
            ]);

            $ekstrakurikulerSiswa = App\Models\Master\EkstrakurikulerSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'kelassiswa_id' => $request->kelassiswa_id,
                'guru_id' => $request->guru_id,
                'tglmasuk' => $request->tglmasuk,
                'tglkeluar' => $request->tglkeluar,
                'keterangan' => $request->keterangan,
                'ekstrakurikuler_id' => $request->ekstrakurikuler_id
            ]);
            $log = $this->logActivity('Create', $request, json_encode($ekstrakurikulerSiswa));
            return $this->successResponse('Ekstrakurikuler Siswa created successfully', $ekstrakurikulerSiswa);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'kelassiswa_id' => 'required',
                'guru_id' => 'required',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'nullable|date',
                'keterangan' => 'nullable|string',
                'ekstrakurikuler_id' => 'required'
            ]);

            $ekstrakurikulerSiswa = App\Models\Master\EkstrakurikulerSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if ($ekstrakurikulerSiswa === null) {
                return $this->failedResponse('Ekstrakurikuler Siswa not found');
            } else {
                $ekstrakurikulerSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'kelassiswa_id' => $request->kelassiswa_id,
                    'guru_id' => $request->guru_id,
                    'tglmasuk' => $request->tglmasuk,
                    'tglkeluar' => $request->tglkeluar,
                    'keterangan' => $request->keterangan,
                    'ekstrakurikuler_id' => $request->ekstrakurikuler_id
                ]);
                $log = $this->logActivity('Update', $request, json_encode($ekstrakurikulerSiswa));
                return $this->successResponse('Ekstrakurikuler Siswa updated successfully', $ekstrakurikulerSiswa);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ekstrakurikulerSiswa = App\Models\Master\EkstrakurikulerSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if ($ekstrakurikulerSiswa === null) {
                return $this->failedResponse('Ekstrakurikuler Siswa not found');
            } else {
                $ekstrakurikulerSiswa->update([
                    'statusenabled' => 0
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($ekstrakurikulerSiswa));
                return $this->successResponse('Ekstrakurikuler Siswa deleted successfully');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
