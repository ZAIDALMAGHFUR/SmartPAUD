<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HistoryKesehatanSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $historyKesehatanSiswas = Cache::remember('history_kesehatan_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\HistoryKesehatanSiswa::with([
                'siswaTransaksi',
                'guru'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($historyKesehatanSiswas->isEmpty()) {
            return $this->failedResponse('History Kesehatan Siswa not found');
        } else {
            return $this->successResponse('History Kesehatan Siswa retrieved successfully', $historyKesehatanSiswas);
        }
    }

    public function show($id)
    {
        $historyKesehatanSiswa = App\Models\Master\HistoryKesehatanSiswa::with([
            'siswaTransaksi',
            'guru'
        ])
            ->where('id', $id)
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->first();

        if ($historyKesehatanSiswa) {
            return $this->successResponse('History Kesehatan Siswa retrieved successfully', $historyKesehatanSiswa);
        } else {
            return $this->failedResponse('History Kesehatan Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'siswatransaksi_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'keluhan' => 'required|string',
                'diagnosa' => 'required|string',
                'tindakan' => 'required|string',
                'keterangan' => 'required|string',
            ]);

            $historyKesehatanSiswa = App\Models\Master\HistoryKesehatanSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'siswatransaksi_id' => $request->siswatransaksi_id,
                'guru_id' => $request->guru_id,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'keterangan' => $request->keterangan,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($historyKesehatanSiswa));
            return $this->successResponse('History Kesehatan Siswa stored successfully', $historyKesehatanSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'siswatransaksi_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'keluhan' => 'required|string',
                'diagnosa' => 'required|string',
                'tindakan' => 'required|string',
                'keterangan' => 'required|string',
            ]);

            $historyKesehatanSiswa = App\Models\Master\HistoryKesehatanSiswa::where('id', $id)
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->first();

            if ($historyKesehatanSiswa) {
                $historyKesehatanSiswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'siswatransaksi_id' => $request->siswatransaksi_id,
                    'guru_id' => $request->guru_id,
                    'keluhan' => $request->keluhan,
                    'diagnosa' => $request->diagnosa,
                    'tindakan' => $request->tindakan,
                    'keterangan' => $request->keterangan,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($historyKesehatanSiswa));
                return $this->successResponse('History Kesehatan Siswa updated successfully', $historyKesehatanSiswa);
            } else {
                return $this->failedResponse('History Kesehatan Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $historyKesehatanSiswa = App\Models\Master\HistoryKesehatanSiswa::find($id);
            if ($historyKesehatanSiswa) {
                $historyKesehatanSiswa->update([
                    'statusenabled' => 0,
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($historyKesehatanSiswa));
                return $this->successResponse('History Kesehatan Siswa deleted successfully', $historyKesehatanSiswa);
            } else {
                return $this->failedResponse('History Kesehatan Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
