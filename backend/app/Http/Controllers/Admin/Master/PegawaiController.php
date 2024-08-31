<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class PegawaiController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $pegawais = App\Models\Master\Pegawai::with([
            'agama', 'jeniskelamin', 'golongandarah', 'pekerjaan',
            'pendidikan', 'statusperkawinan', 'warganegara', 'provinsi', 'kabupaten', 'kecamatan',
            'kelurahan', 'jabatan', 'jenispegawai', 'golonganpegawai', 'unitkerja',
            'kategorypegawai', 'statuspegawai', 'kelompokpegawai', 'shiftkerja'
        ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);

        if ($pegawais->isEmpty()) {
            return $this->failedResponse('Pegawai not found');
        } else {
            return $this->successResponse('Pegawai retrieved successfully', $pegawais);
        }
    }

    public function show($id)
    {
        $pegawai = App\Models\Master\Pegawai::with([
            'agama', 'jeniskelamin', 'golongandarah', 'pekerjaan',
            'pendidikan', 'statusperkawinan', 'warganegara', 'provinsi', 'kabupaten', 'kecamatan',
            'kelurahan', 'jabatan', 'jenispegawai', 'golonganpegawai', 'unitkerja',
            'kategorypegawai', 'statuspegawai', 'kelompokpegawai', 'shiftkerja'
        ])
            ->find($id);

        if ($pegawai) {
            return $this->successResponse('Pegawai retrieved successfully', $pegawai);
        } else {
            return $this->failedResponse('Pegawai not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
            ]);

            $pegawai = App\Models\Master\Pegawai::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'golongandarah_id' => $request->golongandarah_id,
                'pekerjaan_id' => $request->pekerjaan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'statusperkawinan_id' => $request->statusperkawinan_id,
                'warganegara_id' => $request->warganegara_id,
                'namalengkap' => $request->namalengkap,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'nobpjs' => $request->nobpjs,
                'nopaspor' => $request->nopaspor,
                'nokk' => $request->nokk,
                'noasuransilain' => $request->noasuransilain,
                'nip' => $request->nip,
                'nosip' => $request->nosip,
                'nostr' => $request->nostr,
                'tglberakhirsip' => $request->tglberakhirsip,
                'tglberakhirstr' => $request->tglberakhirstr,
                'tglterbitsip' => $request->tglterbitsip,
                'tglterbitstr' => $request->tglterbitstr,
                'kddokterbpjs' => $request->kddokterbpjs,
                'isdpjp' => $request->isdpjp,
                'tgllahir' => $request->tgllahir,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'kodepos' => $request->kodepos,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'jabatan_id' => $request->jabatan_id,
                'jenispegawai_id' => $request->jenispegawai_id,
                'golonganpegawai_id' => $request->golonganpegawai_id,
                'unitkerja_id' => $request->unitkerja_id,
                'kategorypegawai_id' => $request->kategorypegawai_id,
                'statuspegawai_id' => $request->statuspegawai_id,
                'kelompokpegawai_id' => $request->kelompokpegawai_id,
                'shiftkerja_id' => $request->shiftkerja_id,
                'namabank' => $request->namabank,
                'norekening' => $request->norekening,
                'namarekening' => $request->namarekening,
                'namakeluarga' => $request->namakeluarga,
                'fingerprintid' => $request->fingerprintid,
                'tgldaftarfingerprint' => $request->tgldaftarfingerprint,
                'tglmasuk' => $request->tglmasuk,
                'tglkeluar' => $request->tglkeluar,
                'photo' => $request->photo,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($pegawai));
            return $this->successCreatedResponse('pegawai created successfully', $pegawai);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->getMessage());
        } catch (\Exception $e) {
            return $this->failedResponse('An error occurred', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
            ]);

            $pegawai = App\Models\Master\Pegawai::find($id);

            $pegawai->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'golongandarah_id' => $request->golongandarah_id,
                'pekerjaan_id' => $request->pekerjaan_id,
                'pendidikan_id' => $request->pendidikan_id,
                'statusperkawinan_id' => $request->statusperkawinan_id,
                'warganegara_id' => $request->warganegara_id,
                'namalengkap' => $request->namalengkap,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'nobpjs' => $request->nobpjs,
                'nopaspor' => $request->nopaspor,
                'nokk' => $request->nokk,
                'noasuransilain' => $request->noasuransilain,
                'nip' => $request->nip,
                'nosip' => $request->nosip,
                'nostr' => $request->nostr,
                'tglberakhirsip' => $request->tglberakhirsip,
                'tglberakhirstr' => $request->tglberakhirstr,
                'tglterbitsip' => $request->tglterbitsip,
                'tglterbitstr' => $request->tglterbitstr,
                'kddokterbpjs' => $request->kddokterbpjs,
                'isdpjp' => $request->isdpjp,
                'tgllahir' => $request->tgllahir,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'kodepos' => $request->kodepos,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'jabatan_id' => $request->jabatan_id,
                'jenispegawai_id' => $request->jenispegawai_id,
                'golonganpegawai_id' => $request->golonganpegawai_id,
                'unitkerja_id' => $request->unitkerja_id,
                'kategorypegawai_id' => $request->kategorypegawai_id,
                'statuspegawai_id' => $request->statuspegawai_id,
                'kelompokpegawai_id' => $request->kelompokpegawai_id,
                'shiftkerja_id' => $request->shiftkerja_id,
                'namabank' => $request->namabank,
                'norekening' => $request->norekening,
                'namarekening' => $request->namarekening,
                'namakeluarga' => $request->namakeluarga,
                'fingerprintid' => $request->fingerprintid,
                'tgldaftarfingerprint' => $request->tgldaftarfingerprint,
                'tglmasuk' => $request->tglmasuk,
                'tglkeluar' => $request->tglkeluar,
                'photo' => $request->photo,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($pegawai));
            return $this->successResponse('pegawai Updated successfully', $pegawai);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->getMessage());
        } catch (\Exception $e) {
            return $this->failedResponse('An error occurred', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $pegawai = App\Models\Master\Pegawai::find($id);

        if ($pegawai) {
            $pegawai->update([
                'statusenabled' => 0
            ]);

            $log = $this->logActivity('Delete', $request, json_encode($pegawai));
            return $this->successResponse('pegawai deleted successfully', $pegawai);
        } else {
            return $this->failedResponse('pegawai not found');
        }
    }
}
