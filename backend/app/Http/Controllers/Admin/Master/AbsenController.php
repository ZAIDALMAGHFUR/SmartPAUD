<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class AbsenController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $absens = Cache::remember('absen_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\Absen::with([
                'siswatransaksi',
                'guru',
                'matapelajaran',
                'kelas',
                'tahunajaran',
            ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);
        });

        if ($absens->isEmpty()) {
            return $this->failedResponse('Absen not found');
        } else {
            return $this->successResponse('Absen retrieved successfully', $absens);
        }
    }

    public function show($id)
    {
        $absen = App\Models\Master\Absen::with([
            'siswatransaksi',
            'guru',
            'matapelajaran',
            'kelas',
            'tahunajaran',
        ])
        ->where('id', $id)
        ->where('statusenabled', $this->statusEnabled())
        ->where('kdprofile', $this->kdprofile())
        ->first();

        if ($absen === null) {
            return $this->failedResponse('Absen not found');
        } else {
            return $this->successResponse('Absen retrieved successfully', $absen);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'rangkuman' => 'required|string',
                'beritaacara' => 'nullable|string',
                'siswatransaksi_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'matapelajaran_id' => 'required|integer',
                'kelas_id' => 'required|integer',
                'tahunajaran_id' => 'required|integer',
            ]);

            $absen = App\Models\Master\Absen::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'status' => $request->status,
                'rangkuman' => $request->rangkuman,
                'beritaacara' => $request->beritaacara,
                'siswatransaksi_id' => $request->siswatransaksi_id,
                'guru_id' => $request->guru_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($absen));
            return $this->successCreatedResponse('Absen created successfully', $absen);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'rangkuman' => 'required|string',
                'beritaacara' => 'nullable|string',
                'siswatransaksi_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'matapelajaran_id' => 'required|integer',
                'kelas_id' => 'required|integer',
                'tahunajaran_id' => 'required|integer',
            ]);

            $absen = App\Models\Master\Absen::where('id', $id)
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->first();

            if ($absen === null) {
                return $this->failedResponse('Absen not found');
            } else {
                $absen->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'status' => $request->status,
                    'rangkuman' => $request->rangkuman,
                    'beritaacara' => $request->beritaacara,
                    'siswatransaksi_id' => $request->siswatransaksi_id,
                    'guru_id' => $request->guru_id,
                    'matapelajaran_id' => $request->matapelajaran_id,
                    'kelas_id' => $request->kelas_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($absen));
                return $this->successUpdatedResponse('Absen updated successfully', $absen);
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $absen = App\Models\Master\Absen::where('id', $id)
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->first();

            if ($absen === null) {
                return $this->failedResponse('Absen not found');
            } else {
                $absen->update([
                    'statusenabled' => 0,
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($absen));
                return $this->successDeletedResponse('Absen deleted successfully', $absen);
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
