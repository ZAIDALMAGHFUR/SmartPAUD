<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class SiswaController extends Controller
{
    use App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $siswas = App\Models\Master\Siswa::with([
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'Users',
            'jenisKelamin',
            'agama',
            'warganegara',
            'golonganDarah',
            'statusSiswa',
            'statusTempatTinggal',
            'pendidikanAyah',
            'pendidikanIbu',
            'pekerjaanAyah',
            'pekerjaanIbu',
            'pendidikanWali',
            'hubunganWali',
            'pekerjaanWali',
            'TahunAjaran'
        ])
        ->where('statusenabled', $this->statusEnabled())
        ->where('kdprofile', $this->kdprofile())
        ->paginate($perPage);

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
            'jenisKelamin',
            'agama',
            'warganegara',
            'golonganDarah',
            'statusSiswa',
            'statusTempatTinggal',
            'pendidikanAyah',
            'pendidikanIbu',
            'pekerjaanAyah',
            'pekerjaanIbu',
            'pendidikanWali',
            'hubunganWali',
            'pekerjaanWali',
            'TahunAjaran'
        ])->find($id);

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
                'jeniskelamin_id' => 'required',
                'tanggallahir' => 'required',
                'tempatlahir' => 'required',
                'agama_id' => 'required',
                'warganegara_id' => 'required',
                'statustempattinggal_id' => 'required',
                'namaayah' => 'required',
                'namaibu' => 'required',
            ]);

            $siswa = App\Models\Master\Siswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'users_id' => auth()->id(),
                'namalengkap' => $request->namalengkap,
                'namapenggilan' => $request->namapenggilan,
                'nisn' => App\Models\Master\Siswa::generateNisn(),
                'nis' => App\Models\Master\Siswa::generateNis(),
                'nik' => $request->nik,
                'email' => $request->email,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'statussiswa_id' => $request->statussiswa_id,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tanggallahir,
                'agama_id' => $request->agama_id,
                'warganegara_id' => $request->warganegara_id,
                'saudarakandung' => $request->saudarakandung,
                'saudaratiri' => $request->saudaratiri,
                'saudaraangkat' => $request->saudaraangkat,
                'bahasaseharihari' => $request->bahasaseharihari,
                'beratbadan' => $request->beratbadan,
                'tinggibadan' => $request->tinggibadan,
                'golongandarah_id' => $request->golongandarah_id,
                'penyakitpernahdiderita' => $request->penyakitpernahdiderita,
                'alamatrumah' => $request->alamatrumah,
                'nohandphone' => $request->nohandphone,
                'statustempattinggal_id' => $request->statustempattinggal_id,
                'jaraktempattinggalkesekolah' => $request->jaraktempattinggalkesekolah,
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
                'foto' => $request->foto,
                'asalpesertadidik' => $request->asalpesertadidik,
                'namalembaga' => $request->namalembaga,
                'alamatlembaga' => $request->alamatlembaga,
                'namalembagapindah' => $request->namalembagapindah,
                'alamatlembagaasal' => $request->alamatlembagaasal,
                'daritingkatkelompokumur' => $request->daritingkatkelompokumur,
                'padatanggal' => $request->padatanggal,
                'kelompokumur' => $request->kelompokumur,
                'tahunajaran_id' => $request->tahunajaran_id,
                'notanggalsuratketerangan' => $request->notanggalsuratketerangan,
                'melanjutkelembaga' => $request->melanjutkelembaga,
                'pindahlembagadarikelompokumur' => $request->pindahlembagadarikelompokumur,
                'pindahkelembaga' => $request->pindahkelembaga,
                'pindahlembagatingkatkelompokumur' => $request->pindahlembagatingkatkelompokumur,
                'pindahlembagapadatanggal' => $request->pindahlembagapadatanggal,
                'keluarlembagapadatanggal' => $request->keluarlembagapadatanggal,
                'sebabdanalasankeluarlembaga' => $request->sebabdanalasankeluarlembaga,
                'catatanpenting' => $request->catatanpenting
            ]);

            $this->logActivity('Create', $request, json_encode($siswa));
            return $this->successCreatedResponse('Siswa created successfully', $siswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'jeniskelamin_id' => 'required',
                'tanggallahir' => 'required',
                'tempatlahir' => 'required',
                'agama_id' => 'required',
                'warganegara_id' => 'required',
                'statustempattinggal_id' => 'required',
                'namaayah' => 'required',
                'namaibu' => 'required',
            ]);

            $siswa = App\Models\Master\Siswa::find($id);
            if ($siswa) {
                $siswa->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'namalengkap' => $request->namalengkap,
                'namapenggilan' => $request->namapenggilan,
                'nik' => $request->nik,
                'email' => $request->email,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'statussiswa_id' => $request->statussiswa_id,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tanggallahir,
                'agama_id' => $request->agama_id,
                'warganegara_id' => $request->warganegara_id,
                'saudarakandung' => $request->saudarakandung,
                'saudaratiri' => $request->saudaratiri,
                'saudaraangkat' => $request->saudaraangkat,
                'bahasaseharihari' => $request->bahasaseharihari,
                'beratbadan' => $request->beratbadan,
                'tinggibadan' => $request->tinggibadan,
                'golongandarah_id' => $request->golongandarah_id,
                'penyakitpernahdiderita' => $request->penyakitpernahdiderita,
                'alamatrumah' => $request->alamatrumah,
                'nohandphone' => $request->nohandphone,
                'statustempattinggal_id' => $request->statustempattinggal_id,
                'jaraktempattinggalkesekolah' => $request->jaraktempattinggalkesekolah,
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
                'foto' => $request->foto,
                'asalpesertadidik' => $request->asalpesertadidik,
                'namalembaga' => $request->namalembaga,
                'alamatlembaga' => $request->alamatlembaga,
                'namalembagapindah' => $request->namalembagapindah,
                'alamatlembagaasal' => $request->alamatlembagaasal,
                'daritingkatkelompokumur' => $request->daritingkatkelompokumur,
                'padatanggal' => $request->padatanggal,
                'kelompokumur' => $request->kelompokumur,
                'tahunajaran_id' => $request->tahunajaran_id,
                'notanggalsuratketerangan' => $request->notanggalsuratketerangan,
                'melanjutkelembaga' => $request->melanjutkelembaga,
                'pindahlembagadarikelompokumur' => $request->pindahlembagadarikelompokumur,
                'pindahkelembaga' => $request->pindahkelembaga,
                'pindahlembagatingkatkelompokumur' => $request->pindahlembagatingkatkelompokumur,
                'pindahlembagapadatanggal' => $request->pindahlembagapadatanggal,
                'keluarlembagapadatanggal' => $request->keluarlembagapadatanggal,
                'sebabdanalasankeluarlembaga' => $request->sebabdanalasankeluarlembaga,
                'catatanpenting' => $request->catatanpenting
                ]);
                $this->logActivity('Update', $request, json_encode($siswa));
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
        $siswa = App\Models\Master\Siswa::find($id);

        if ($siswa) {
            $siswa->update(['statusenabled' => 0]);
            $this->logActivity('Delete', $request, json_encode($siswa));
            return $this->successResponse('Siswa deleted successfully', $siswa);
        } else {
            return $this->failedResponse('Siswa not found');
        }
    }
}
