<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App;

class SiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $siswas = Cache::remember('siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\Siswa::with([
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'Users',
                'agama',
                'jeniskelamin',
                'golongandarah',
                'warganegara',
                'statussiswa',
                'orangTua'
            ])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($siswas->isEmpty()) {
            return $this->failedResponse('Siswa not found');
        } else {
            return $this->successResponse('Siswa retrieved successfully', $siswas);
        }
    }

    public function show($id)
    {
        $siswa = App\Models\Master\Siswa::with([
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'Users',
            'agama',
            'jeniskelamin',
            'golongandarah',
            'warganegara',
            'statussiswa',
            'orangTua'
        ])
            ->where('id', $id)
            ->first();

        if ($siswa) {
            return $this->successResponse('Siswa retrieved successfully', $siswa);
        } else {
            return $this->failedResponse('Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'nik' => 'required',
                'nohp' => 'required',
                'email' => 'required',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'alamat' => 'required',
                'tempatlahir' => 'required',
                'tgllahir' => 'required',
                'anakke' => 'required',
                'jmlsaudarakandung' => 'required',
                'jmlsaudaratiri' => 'required',
                'jmlsaudaraperempuan' => 'required',
                'jmlsaudaralaki' => 'required',
                'tinggibadan' => 'required',
                'beratbadan' => 'required',
                'jmlhafalan' => 'required',
                'jmlhafalansurat' => 'required',
                'jmlhafalanjuz' => 'required',
                'users_id' => 'required',
                'agama_id' => 'required',
                'jeniskelamin_id' => 'required',
                'golongandarah_id' => 'required',
                'statussiswa_id' => 'required',
                'photo' => 'required'
            ]);

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos_siswa', 'public');
            }

            $siswa = App\Models\Master\Siswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
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
                'anakke' => $request->anakke,
                'jmlsaudarakandung' => $request->jmlsaudarakandung,
                'jmlsaudaratiri' => $request->jmlsaudaratiri,
                'jmlsaudaraperempuan' => $request->jmlsaudaraperempuan,
                'jmlsaudaralaki' => $request->jmlsaudaralaki,
                'tinggibadan' => $request->tinggibadan,
                'beratbadan' => $request->beratbadan,
                'jmlhafalan' => $request->jmlhafalan,
                'jmlhafalansurat' => $request->jmlhafalansurat,
                'jmlhafalanjuz' => $request->jmlhafalanjuz,
                'users_id' => $request->users_id,
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'golongandarah_id' => $request->golongandarah_id,
                'statussiswa_id' => $request->statussiswa_id,
                'photo' => $photoPath
            ]);

            $log = $this->logActivity('Create', $request, json_encode($siswa));
            return $this->successResponse('Siswa created successfully', $siswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'nik' => 'required',
                'nohp' => 'required',
                'email' => 'required',
                'provinsi_id' => 'required',
                'kabupaten_id' => 'required',
                'kecamatan_id' => 'required',
                'kelurahan_id' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'alamat' => 'required',
                'tempatlahir' => 'required',
                'tgllahir' => 'required',
                'anakke' => 'required',
                'jmlsaudarakandung' => 'required',
                'jmlsaudaratiri' => 'required',
                'jmlsaudaraperempuan' => 'required',
                'jmlsaudaralaki' => 'required',
                'tinggibadan' => 'required',
                'beratbadan' => 'required',
                'jmlhafalan' => 'required',
                'jmlhafalansurat' => 'required',
                'jmlhafalanjuz' => 'required',
                'users_id' => 'required',
                'agama_id' => 'required',
                'jeniskelamin_id' => 'required',
                'golongandarah_id' => 'required',
                'statussiswa_id' => 'required',
                'photo' => 'required'
            ]);

            $siswa = App\Models\Master\Siswa::find($id);

            if ($siswa) {
                $photoPath = $siswa->photo;

                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')->store('photos_siswa', 'public');
                }

                $siswa->update([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
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
                    'anakke' => $request->anakke,
                    'jmlsaudarakandung' => $request->jmlsaudarakandung,
                    'jmlsaudaratiri' => $request->jmlsaudaratiri,
                    'jmlsaudaraperempuan' => $request->jmlsaudaraperempuan,
                    'jmlsaudaralaki' => $request->jmlsaudaralaki,
                    'tinggibadan' => $request->tinggibadan,
                    'beratbadan' => $request->beratbadan,
                    'jmlhafalan' => $request->jmlhafalan,
                    'jmlhafalansurat' => $request->jmlhafalansurat,
                    'jmlhafalanjuz' => $request->jmlhafalanjuz,
                    'users_id' => $request->users_id,
                    'agama_id' => $request->agama_id,
                    'jeniskelamin_id' => $request->jeniskelamin_id,
                    'golongandarah_id' => $request->golongandarah_id,
                    'statussiswa_id' => $request->statussiswa_id,
                    'photo' => $photoPath
                ]);

                $log = $this->logActivity('Update', $request, json_encode($siswa));
                return $this->successResponse('Siswa updated successfully', $siswa);
            } else {
                return $this->failedResponse('Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $siswa = App\Models\Master\Siswa::find($id);

            if ($siswa) {
                $siswa->update([
                    'statusenabled' => 0
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($siswa));
                return $this->successResponse('Siswa deleted successfully', $siswa);
            } else {
                return $this->failedResponse('Siswa not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
