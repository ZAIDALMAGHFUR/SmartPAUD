<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App;

class SiswaTransaksiController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $siswaTransaksi = Cache::remember('siswa_transaksi_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\SiswaTransaksi::with([
                'siswa',
                'kelas',
                'tahunAjaran',
                'guru'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($siswaTransaksi->isEmpty()) {
            return $this->failedResponse('Siswa Transaksi not found');
        } else {
            return $this->successResponse('Siswa Transaksi retrieved successfully', $siswaTransaksi);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'siswa_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
                'guru_id' => 'required',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'nullable|date',
                'keterangan' => 'nullable|string',
            ]);

            $siswaTransaksi = App\Models\Master\SiswaTransaksi::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'siswa_id' => $request->siswa_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
                'guru_id' => $request->guru_id,
                'tglmasuk' => $request->tglmasuk,
                'tglkeluar' => $request->tglkeluar,
                'keterangan' => $request->keterangan,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($siswaTransaksi));
            return $this->successResponse('Siswa Transaksi created successfully', $siswaTransaksi);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $siswaTransaksi = Cache::remember('siswa_transaksi_' . $id, 60, function () use ($id) {
            return App\Models\Master\SiswaTransaksi::with([
                'siswa',
                'kelas',
                'tahunAjaran',
                'guru'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->find($id);
        });

        if ($siswaTransaksi === null) {
            return $this->failedResponse('Siswa Transaksi not found');
        } else {
            return $this->successResponse('Siswa Transaksi retrieved successfully', $siswaTransaksi);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'siswa_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
                'guru_id' => 'required',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'nullable|date',
                'keterangan' => 'nullable|string',
            ]);

            $siswaTransaksi = App\Models\Master\SiswaTransaksi::where('id', $id)
                ->where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->first();

            if ($siswaTransaksi) {
                $siswaTransaksi->update([
                    'siswa_id' => $request->siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'tahunajaran_id' => $request->tahunajaran_id,
                    'guru_id' => $request->guru_id,
                    'tglmasuk' => $request->tglmasuk,
                    'tglkeluar' => $request->tglkeluar,
                    'keterangan' => $request->keterangan,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($siswaTransaksi));
                return $this->successResponse('Siswa Transaksi updated successfully', $siswaTransaksi);
            } else {
                return $this->failedResponse('Siswa Transaksi not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $siswaTransaksi = App\Models\Master\SiswaTransaksi::where('id', $id)
                ->where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->first();

            if ($siswaTransaksi) {
                $siswaTransaksi->update([
                    'statusenabled' => 0
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($siswaTransaksi));
                return $this->successResponse('Siswa Transaksi deleted successfully', $siswaTransaksi);
            } else {
                return $this->failedResponse('Siswa Transaksi not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
