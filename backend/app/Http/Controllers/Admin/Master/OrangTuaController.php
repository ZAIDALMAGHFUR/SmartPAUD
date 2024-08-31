<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class OrangTuaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $orangTua = Cache::remember('orang_tua_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\OrangTua::with([
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'Users',
                'agama',
                'jeniskelamin',
                'golongandarah',
                'warganegara',
                'pekerjaan',
                'pendidikan',
                'hubunganKeluarga',
                'siswa'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($orangTua->isEmpty()) {
            return $this->failedResponse('Orang Tua not found');
        } else {
            return $this->successResponse('Orang Tua retrieved successfully', $orangTua);
        }
    }

    public function show($id)
    {
        $orangTua = Cache::remember('orang_tua_list_' . $id, 60, function () use ($id) {
            return App\Models\Master\OrangTua::with([
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'Users',
                'agama',
                'jeniskelamin',
                'golongandarah',
                'warganegara',
                'pekerjaan',
                'pendidikan',
                'hubunganKeluarga',
                'siswa'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->find($id);
        });

        if ($orangTua) {
            return $this->successResponse('Orang Tua retrieved successfully', $orangTua);
        } else {
            return $this->failedResponse('Orang Tua not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'nik' => 'required|unique:orangtua,nik',
                'nohp' => 'required',
                'email' => 'required|email|unique:orangtua,email',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'alamat' => 'required',
                'tempatlahir' => 'required',
                'tgllahir' => 'required|date',
                'agama_id' => 'required',
                'jeniskelamin_id' => 'required',
                'golongandarah_id' => 'required',
                'warganegara_id' => 'required',
                'pekerjaan_id' => 'required',
                'pendidikan_id' => 'required',
                'penghasilan' => 'required|integer',
                'hubungankeluarga_id' => 'required',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'users_id' => 'required',
                'no_kk' => 'nullable',
                'no_ktp' => 'nullable',
                'no_kis' => 'nullable',
                'no_kks' => 'nullable',
                'no_kps' => 'nullable',
                'no_kip' => 'nullable',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos_orangtua', 'public');
            }

            $orangTua = App\Models\Master\OrangTua::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'users_id' => $request->users_id,
                'namalengkap' => $request->namalengkap,
                'nik' => $request->nik,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'alamat' => $request->alamat,
                'tempatlahir' => $request->tempatlahir,
                'tgllahir' => $request->tgllahir,
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'golongandarah_id' => $request->golongandarah_id,
                'warganegara_id' => $request->warganegara_id,
                'photo' => $photoPath,
                'pekerjaan_id' => $request->pekerjaan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'penghasilan' => $request->penghasilan,
                'hubungankeluarga_id' => $request->hubungankeluarga_id,
                'no_kk' => $request->no_kk,
                'no_ktp' => $request->no_ktp,
                'no_kis' => $request->no_kis,
                'no_kks' => $request->no_kks,
                'no_kps' => $request->no_kps,
                'no_kip' => $request->no_kip,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($orangTua));
            return $this->successResponse('Orang tua created successfully', $orangTua);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $orangTua = App\Models\Master\OrangTua::find($id);

            if (!$orangTua) {
                return $this->failedResponse('Orang Tua not found');
            }

            $request->validate([
                'namalengkap' => 'required',
                // 'nik' => 'required|unique:orangtua,nik,' . $id,
                'nohp' => 'required',
                // 'email' => 'required|email|unique:orangtua,email,' . $id,
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'alamat' => 'required',
                'tempatlahir' => 'required',
                'tgllahir' => 'required|date',
                'agama_id' => 'required',
                'jeniskelamin_id' => 'required',
                'golongandarah_id' => 'required',
                'warganegara_id' => 'required',
                'pekerjaan_id' => 'required',
                'pendidikan_id' => 'required',
                'penghasilan' => 'required|integer',
                'hubungankeluarga_id' => 'required',
                // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'users_id' => 'required',
                'no_kk' => 'nullable',
                'no_ktp' => 'nullable',
                'no_kis' => 'nullable',
                'no_kks' => 'nullable',
                'no_kps' => 'nullable',
                'no_kip' => 'nullable',
            ]);

            $photoPath = $orangTua->photo;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos_orangtua', 'public');
            }

            $orangTua->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'users_id' => $request->users_id,
                'namalengkap' => $request->namalengkap,
                'nik' => $request->nik,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'alamat' => $request->alamat,
                'tempatlahir' => $request->tempatlahir,
                'tgllahir' => $request->tgllahir,
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'golongandarah_id' => $request->golongandarah_id,
                'warganegara_id' => $request->warganegara_id,
                'photo' => $photoPath,
                'pekerjaan_id' => $request->pekerjaan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'penghasilan' => $request->penghasilan,
                'hubungankeluarga_id' => $request->hubungankeluarga_id,
                'no_kk' => $request->no_kk,
                'no_ktp' => $request->no_ktp,
                'no_kis' => $request->no_kis,
                'no_kks' => $request->no_kks,
                'no_kps' => $request->no_kps,
                'no_kip' => $request->no_kip,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($orangTua));
            return $this->successResponse('Orang Tua updated successfully', $orangTua);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $orangTua = App\Models\Master\OrangTua::find($id);

            if (!$orangTua) {
                return $this->failedResponse('Orang Tua not found');
            }
            $orangTua->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($orangTua));
            return $this->successResponse('Orang Tua deleted successfully', $orangTua);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
