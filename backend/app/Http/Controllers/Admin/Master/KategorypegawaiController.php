<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class KategorypegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $kategorypegawais = App\Models\Master\Kategorypegawai::where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($kategorypegawais->isEmpty()) {
            return $this->failedResponse('Kategori Pegawai not found');
        } else {
            return $this->successResponse('Kategori Pegawai retrieved successfully', $kategorypegawais);
        }
    }

    public function show($id)
    {
        $kategorypegawai = App\Models\Master\Kategorypegawai::find($id);

        if ($kategorypegawai) {
            return $this->successResponse('Kategori Pegawai retrieved successfully', $kategorypegawai);
        } else {
            return $this->failedResponse('Kategori Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $kategorypegawai = App\Models\Master\Kategorypegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($kategorypegawai));
            return $this->successCreatedResponse('Kategori Pegawai created successfully', $kategorypegawai);
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

            $kategorypegawai = App\Models\Master\Kategorypegawai::find($id);
            $kategorypegawai->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($kategorypegawai));
            return $this->successResponse('Kategori Pegawai updated successfully', $kategorypegawai);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $kategorypegawai = App\Models\Master\Kategorypegawai::find($id);

        if ($kategorypegawai) {
            $kategorypegawai->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($kategorypegawai));
            return $this->successResponse('Kategori Pegawai deleted successfully', $kategorypegawai);
        } else {
            return $this->failedResponse('Kategori Pegawai not found');
        }
    }
}
