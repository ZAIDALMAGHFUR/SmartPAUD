<?php

namespace App\Http\Controllers\Admin\Master\Region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class RegionController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function getProvinces()
    {
        $regions = App\Models\Master\Provinsi::all();

        if ($regions->isEmpty()) {
            return $this->failedResponse('Region not found');
        } else {
            return $this->successResponse('Region retrieved successfully', $regions);
        }
    }

    public function getKabupatens($provinceId)
    {
        $regions = App\Models\Master\Kabupaten::where('provinsi_id', $provinceId)->get();

        if ($regions->isEmpty()) {
            return $this->failedResponse('Region not found');
        } else {
            return $this->successResponse('Region retrieved successfully', $regions);
        }
    }

    public function getKecamatans($kabupatenId)
    {
        $regions = App\Models\Master\Kecamatan::where('kabupaten_id', $kabupatenId)->get();

        if ($regions->isEmpty()) {
            return $this->failedResponse('Region not found');
        } else {
            return $this->successResponse('Region retrieved successfully', $regions);
        }
    }

    public function getKelurahans($kecamatanId)
    {
        $regions = App\Models\Master\Kelurahan::where('kecamatan_id', $kecamatanId)->get();

        if ($regions->isEmpty()) {
            return $this->failedResponse('Region not found');
        } else {
            return $this->successResponse('Region retrieved successfully', $regions);
        }
    }

    public function getAllLocations()
    {
        $provinces = App\Models\Master\Provinsi::with('kabupaten','kabupaten.kecamatan','kabupaten.kecamatan.kelurahan')->get();
        return response()->json($provinces);
    }
}
