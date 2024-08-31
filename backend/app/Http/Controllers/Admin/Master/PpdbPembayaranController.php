<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App;

class PpdbPembayaranController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ppdbPembayarans = Cache::remember('ppdb_pembayaran_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\PpdbPembayaran::with([
                'ppdb',
                'jenisPembayaran',
                'statusPembayaran'
            ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);
        });

        if ($ppdbPembayarans->isEmpty()) {
            return $this->failedResponse('Ppdb Pembayaran not found');
        } else {
            return $this->successResponse('Ppdb Pembayaran retrieved successfully', $ppdbPembayarans);
        }
    }

    public function show($id)
    {
        $ppdbPembayaran = App\Models\Master\PpdbPembayaran::with([
            'ppdb',
            'jenisPembayaran',
            'statusPembayaran'
        ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('id', $id)
            ->first();

        if ($ppdbPembayaran) {
            return $this->successResponse('Ppdb Pembayaran retrieved successfully', $ppdbPembayaran);

        } else {
            return $this->failedResponse('Ppdb Pembayaran not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ppdb_id' => 'required',
                'jenispembayaran_id' => 'required',
                'statuspembayaran_id' => 'required',
                'jumlah' => 'required',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('ppdb_pembayaran');
            }

            $ppdbPembayaran = App\Models\Master\PpdbPembayaran::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'ppdb_id' => $request->ppdb_id,
                'jenispembayaran_id' => $request->jenispembayaran_id,
                'statuspembayaran_id' => $request->statuspembayaran_id,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'tglbayar' => $request->tglbayar,
                'photo' => $photoPath,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($ppdbPembayaran));
            return $this->successResponse('Ppdb Pembayaran created successfully', $ppdbPembayaran);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'ppdb_id' => 'required',
                'jenispembayaran_id' => 'required',
                'statuspembayaran_id' => 'required',
                'jumlah' => 'required',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $ppdbPembayaran = App\Models\Master\PpdbPembayaran::where('id', $id)
                ->where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->first();

            if ($ppdbPembayaran) {
                $photoPath = $ppdbPembayaran->photo;
                if ($request->hasFile('photo')) {
                    Storage::delete($photoPath);
                    $photoPath = $request->file('photo')->store('ppdb_pembayaran');
                }

                $ppdbPembayaran->update([
                    'ppdb_id' => $request->ppdb_id,
                    'jenispembayaran_id' => $request->jenispembayaran_id,
                    'statuspembayaran_id' => $request->statuspembayaran_id,
                    'jumlah' => $request->jumlah,
                    'keterangan' => $request->keterangan,
                    'tglbayar' => $request->tglbayar,
                    'photo' => $photoPath,
                ]);

                $log = $this->logActivity('Update', $request, json_encode($ppdbPembayaran));
                return $this->successResponse('Ppdb Pembayaran updated successfully', $ppdbPembayaran);
            } else {
                return $this->failedResponse('Ppdb Pembayaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ppdbPembayaran = App\Models\Master\PpdbPembayaran::where('id', $id)
                ->where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->first();

            if ($ppdbPembayaran) {
                Storage::delete($ppdbPembayaran->photo);
                $ppdbPembayaran->update([
                    'statusenabled' => 0
                ]);

                $log = $this->logActivity('Delete', $request, json_encode($ppdbPembayaran));
                return $this->successResponse('Ppdb Pembayaran deleted successfully', $ppdbPembayaran);
            } else {
                return $this->failedResponse('Ppdb Pembayaran not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
