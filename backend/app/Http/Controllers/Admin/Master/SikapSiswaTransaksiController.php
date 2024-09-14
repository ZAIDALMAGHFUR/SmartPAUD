<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SikapSiswaTransaksiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $sikapSiswaTransaksis = Cache::remember('sikap_siswa_transaksi_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\SikapSiswaTransaksi::with([
                'KelasSiswa',
                'guru',
                'sikapSiswa'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($sikapSiswaTransaksis->isEmpty()) {
            return $this->failedResponse('Sikap Siswa Transaksi not found');
        } else {
            return $this->successResponse('Sikap Siswa Transaksi retrieved successfully', $sikapSiswaTransaksis);
        }
    }

    public function show($id)
    {
        $sikapSiswaTransaksi = App\Models\Master\SikapSiswaTransaksi::with([
            'KelasSiswa',
            'guru',
            'sikapSiswa'
        ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($sikapSiswaTransaksi) {
            return $this->successResponse('Sikap Siswa Transaksi retrieved successfully', $sikapSiswaTransaksi);
        } else {
            return $this->failedResponse('Sikap Siswa Transaksi not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kelassiswa_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'required|date',
                'keterangan' => 'required|string',
                'sikapsiswa_id' => 'required|integer',
            ]);

            $sikapSiswaTransaksi = App\Models\Master\SikapSiswaTransaksi::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'kelassiswa_id' => $request->kelassiswa_id,
                'guru_id' => $request->guru_id,
                'tglmasuk' => $request->tglmasuk,
                'tglkeluar' => $request->tglkeluar,
                'keterangan' => $request->keterangan,
                'sikapsiswa_id' => $request->sikapsiswa_id,
            ]);
            $log = $this->logActivity('Create', $request, json_encode($sikapSiswaTransaksi));
            return $this->successResponse('Sikap Siswa Transaksi created successfully', $sikapSiswaTransaksi);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kelassiswa_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'tglmasuk' => 'required|date',
                'tglkeluar' => 'required|date',
                'keterangan' => 'required|string',
                'sikapsiswa_id' => 'required|integer',
            ]);

            $sikapSiswaTransaksi = App\Models\Master\SikapSiswaTransaksi::find($id);
            if ($sikapSiswaTransaksi) {
                $sikapSiswaTransaksi->update([
                    'kelassiswa_id' => $request->kelassiswa_id,
                    'guru_id' => $request->guru_id,
                    'tglmasuk' => $request->tglmasuk,
                    'tglkeluar' => $request->tglkeluar,
                    'keterangan' => $request->keterangan,
                    'sikapsiswa_id' => $request->sikapsiswa_id,
                ]);
                $log = $this->logActivity('Update', $request, json_encode($sikapSiswaTransaksi));
                return $this->successResponse('Sikap Siswa Transaksi updated successfully', $sikapSiswaTransaksi);
            } else {
                return $this->failedResponse('Sikap Siswa Transaksi not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $sikapSiswaTransaksi = App\Models\Master\SikapSiswaTransaksi::find($id);
        if ($sikapSiswaTransaksi) {
            $sikapSiswaTransaksi->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($sikapSiswaTransaksi));
            return $this->successResponse('Sikap Siswa Transaksi deleted successfully', $sikapSiswaTransaksi);
        } else {
            return $this->failedResponse('Sikap Siswa Transaksi not found');
        }
    }
}
