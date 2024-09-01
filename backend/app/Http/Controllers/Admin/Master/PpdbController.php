<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class PpdbController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ppdbs = \App\Models\Master\Ppdb::with([
            'user',
            'jenisKelamin',
            'agama',
            'wargaNegara',
            'golonganDarah',
            'statusTempatTinggal',
            'pendidikanAyah',
            'pendidikanIbu',
            'pekerjaanAyah',
            'pekerjaanIbu',
            'pendidikanWali',
            'hubunganWali',
            'pekerjaanWali',
            'statusMasuk',
            'statusPendaftaran'
        ])
        ->where('statusenabled', $this->statusEnabled())
        ->where('kdprofile', $this->kdprofile())
        ->paginate($perPage);

        if ($ppdbs->isEmpty()) {
            return $this->failedResponse('PPDB not found');
        } else {
            return $this->successResponse('PPDB retrieved successfully', $ppdbs);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'jeniskelamin_id' => 'required|exists:jenis_kelamin,id',
                'tanggallahir' => 'required|date',
                'tempatlahir' => 'required',
                'agama_id' => 'required|exists:agama,id',
                'warganegara_id' => 'required|exists:warga_negara,id',
                'statustempattinggal_id' => 'required|exists:status_tempat_tinggal,id',
                'namaayah' => 'required',
                'namaibu' => 'required',
                'statuspendaftaran_id' => 'required|exists:status_pendaftaran,id',
            ]);

            $ppdb = App\Models\Master\Ppdb::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'users_id' => auth()->id(),
                'namalengkap' => $request->namalengkap,
                'namapanggilan' => $request->namapanggilan,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'tanggallahir' => $request->tanggallahir,
                'tempatlahir' => $request->tempatlahir,
                'agama_id' => $request->agama_id,
                'warganegara_id' => $request->warganegara_id,
                'anaknomorke' => $request->anaknomorke,
                'jumlahsaudarakandung' => $request->jumlahsaudarakandung,
                'jumlahsaudaratiri' => $request->jumlahsaudaratiri,
                'jumlahsaudaraangkat' => $request->jumlahsaudaraangkat,
                'bahasaseharihari' => $request->bahasaseharihari,
                'beratbadan' => $request->beratbadan,
                'tinggibadan' => $request->tinggibadan,
                'golongandarah_id' => $request->golongandarah_id,
                'penyakitpernahdiderita' => $request->penyakitpernahdiderita,
                'alamattempattinggal' => $request->alamattempattinggal,
                'nomortelepon' => $request->nomortelepon,
                'statustempattinggal_id' => $request->statustempattinggal_id,
                'namaayah' => $request->namaayah,
                'namaibu' => $request->namaibu,
                'pendidikan_ayah_id' => $request->pendidikan_ayah_id,
                'pendidikan_ibu_id' => $request->pendidikan_ibu_id,
                'pekerjaan_ayah_id' => $request->pekerjaan_ayah_id,
                'pekerjaan_ibu_id' => $request->pekerjaan_ibu_id,
                'namawali' => $request->namawali,
                'pendidikan_wali_id' => $request->pendidikan_wali_id,
                'hubunganwali_id' => $request->hubunganwali_id,
                'pekerjaan_wali_id' => $request->pekerjaan_wali_id,
                'statusmasuk_id' => $request->statusmasuk_id,
                'namatkasal' => $request->namatkasal,
                'tanggalpindahan' => $request->tanggalpindahan,
                'kelompokpindahan' => $request->kelompokpindahan,
                'tanggalditerima' => $request->tanggalditerima,
                'kelompokditerima' => $request->kelompokditerima,
                'statuspendaftaran_id' => $request->statuspendaftaran_id,
                'alasanpenolakan' => $request->alasanpenolakan,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($ppdb));
            return $this->successCreatedResponse('PPDB created successfully', $ppdb);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $ppdb = \App\Models\Master\Ppdb::with([
            'user',
            'jenisKelamin',
            'agama',
            'wargaNegara',
            'golonganDarah',
            'statusTempatTinggal',
            'pendidikanAyah',
            'pendidikanIbu',
            'pekerjaanAyah',
            'pekerjaanIbu',
            'pendidikanWali',
            'hubunganWali',
            'pekerjaanWali',
            'statusMasuk',
            'statusPendaftaran'
        ])
        ->find($id);

        if ($ppdb) {
            return $this->successResponse('PPDB retrieved successfully', $ppdb);
        } else {
            return $this->failedResponse('PPDB not found');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'jeniskelamin_id' => 'required|exists:jenis_kelamin,id',
                'tanggallahir' => 'required|date',
                'tempatlahir' => 'required',
                'agama_id' => 'required|exists:agama,id',
                'warganegara_id' => 'required|exists:warga_negara,id',
                'statustempattinggal_id' => 'required|exists:status_tempat_tinggal,id',
                'namaayah' => 'required',
                'namaibu' => 'required',
                'statuspendaftaran_id' => 'required|exists:status_pendaftaran,id',
            ]);

            $ppdb = \App\Models\Master\Ppdb::with([
                'user',
                'jenisKelamin',
                'agama',
                'wargaNegara',
                'golonganDarah',
                'statusTempatTinggal',
                'pendidikanAyah',
                'pendidikanIbu',
                'pekerjaanAyah',
                'pekerjaanIbu',
                'pendidikanWali',
                'hubunganWali',
                'pekerjaanWali',
                'statusMasuk',
                'statusPendaftaran'
            ])
            ->find($id);
            $ppdb->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'namalengkap' => $request->namalengkap,
                'namapanggilan' => $request->namapanggilan,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'tanggallahir' => $request->tanggallahir,
                'tempatlahir' => $request->tempatlahir,
                'agama_id' => $request->agama_id,
                'warganegara_id' => $request->warganegara_id,
                'anaknomorke' => $request->anaknomorke,
                'jumlahsaudarakandung' => $request->jumlahsaudarakandung,
                'jumlahsaudaratiri' => $request->jumlahsaudaratiri,
                'jumlahsaudaraangkat' => $request->jumlahsaudaraangkat,
                'bahasaseharihari' => $request->bahasaseharihari,
                'beratbadan' => $request->beratbadan,
                'tinggibadan' => $request->tinggibadan,
                'golongandarah_id' => $request->golongandarah_id,
                'penyakitpernahdiderita' => $request->penyakitpernahdiderita,
                'alamattempattinggal' => $request->alamattempattinggal,
                'nomortelepon' => $request->nomortelepon,
                'statustempattinggal_id' => $request->statustempattinggal_id,
                'namaayah' => $request->namaayah,
                'namaibu' => $request->namaibu,
                'pendidikan_ayah_id' => $request->pendidikan_ayah_id,
                'pendidikan_ibu_id' => $request->pendidikan_ibu_id,
                'pekerjaan_ayah_id' => $request->pekerjaan_ayah_id,
                'pekerjaan_ibu_id' => $request->pekerjaan_ibu_id,
                'namawali' => $request->namawali,
                'pendidikan_wali_id' => $request->pendidikan_wali_id,
                'hubunganwali_id' => $request->hubunganwali_id,
                'pekerjaan_wali_id' => $request->pekerjaan_wali_id,
                'statusmasuk_id' => $request->statusmasuk_id,
                'namatkasal' => $request->namatkasal,
                'tanggalpindahan' => $request->tanggalpindahan,
                'kelompokpindahan' => $request->kelompokpindahan,
                'tanggalditerima' => $request->tanggalditerima,
                'kelompokditerima' => $request->kelompokditerima,
                'statuspendaftaran_id' => $request->statuspendaftaran_id,
                'alasanpenolakan' => $request->alasanpenolakan,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($ppdb));
            return $this->successUpdatedResponse('PPDB updated successfully', $ppdb);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $ppdb = \App\Models\Master\Ppdb::with([
            'user',
            'jenisKelamin',
            'agama',
            'wargaNegara',
            'golonganDarah',
            'statusTempatTinggal',
            'pendidikanAyah',
            'pendidikanIbu',
            'pekerjaanAyah',
            'pekerjaanIbu',
            'pendidikanWali',
            'hubunganWali',
            'pekerjaanWali',
            'statusMasuk',
            'statusPendaftaran'
        ])
        ->find($id);

        if ($ppdb) {
            $ppdb->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($ppdb));
            return $this->successDeletedResponse('PPDB deleted successfully', $ppdb);
        } else {
            return $this->failedResponse('PPDB not found');
        }
    }
}
