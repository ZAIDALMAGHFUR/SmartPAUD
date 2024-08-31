<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SikapSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $sikapSiswas = Cache::remember('sikap_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\SikapSiswa::where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($sikapSiswas->isEmpty()) {
            return $this->failedResponse('Sikap Siswa not found');
        } else {
            return $this->successResponse('Sikap Siswa retrieved successfully', $sikapSiswas);
        }
    }

    public function show($id)
    {
        $sikapSiswa = App\Models\Master\SikapSiswa::find($id);

        if ($sikapSiswa) {
            return $this->successResponse('Sikap Siswa retrieved successfully', $sikapSiswa);
        } else {
            return $this->failedResponse('Sikap Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $sikapSiswa = App\Models\Master\SikapSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $request->name,
            ]);
            $log = $this->logActivity('Create', $request, json_encode($sikapSiswa));
            return $this->successResponse('Sikap Siswa created successfully', $sikapSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $sikapSiswa = App\Models\Master\SikapSiswa::find($id);
            if ($sikapSiswa) {
                $sikapSiswa->update([
                    'name' => $request->name,
                ]);
                $log = $this->logActivity('Update', $request, json_encode($sikapSiswa));
                return $this->successResponse('Sikap Siswa updated successfully', $sikapSiswa);
            } else {
                return $this->failedResponse('Sikap Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $sikapSiswa = App\Models\Master\SikapSiswa::find($id);
        if ($sikapSiswa) {
            $sikapSiswa->delete();
            $log = $this->logActivity('Delete', $request, json_encode($sikapSiswa));
            return $this->successResponse('Sikap Siswa deleted successfully', $sikapSiswa);
        } else {
            return $this->failedResponse('Sikap Siswa not found');
        }
    }
}
