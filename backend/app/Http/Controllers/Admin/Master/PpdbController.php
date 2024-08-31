<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PpdbController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $ppdbs = Cache::remember('ppdb_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\Ppdb::with([
                'agama',
                'jeniskelamin',
                'jalurpendaftaran',
                'tahunajaran',
                'jenjangpendidikan',
                'jurusan',
                'provinsi',
                'kabupaten',
                'kecamatan',
                'kelurahan',
                'statuspendaftaran',
                'Users'
            ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->paginate($perPage);
        });

        if ($ppdbs->isEmpty()) {
            return $this->failedResponse('Ppdb not found');
        } else {
            return $this->successResponse('Ppdb retrieved successfully', $ppdbs);
        }
    }

    public function show($id)
    {
        $ppdb = App\Models\Master\Ppdb::with([
            'agama',
            'jeniskelamin',
            'jalurpendaftaran',
            'tahunajaran',
            'jenjangpendidikan',
            'jurusan',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'statuspendaftaran',
            'Users'
        ])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);
        if ($ppdb) {
            return $this->successResponse('Ppdb retrieved successfully', $ppdb);
        } else {
            return $this->failedResponse('Ppdb not found');
        }
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'namalengkap' => 'required',
    //             'agama_id' => 'required',
    //             'jeniskelamin_id' => 'required',
    //             'tgllahir' => 'required',
    //             'tempatlahir' => 'required',
    //             'alamat' => 'required',
    //             'jalurpendaftaran_id' => 'required',
    //             'tahunajaran_id' => 'required',
    //             'jenjangpendidikan_id' => 'required',
    //             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         $photoPath = null;

    //         if ($request->hasFile('photo')) {
    //             $photoPath = $request->file('photo')->store('photos_ppdb', 'public');
    //         }

    //         $ppdb = App\Models\Master\Ppdb::create([
    //             'kdprofile' => $this->kdprofile(),
    //             'statusenabled' => $this->statusEnabled(),
    //             'namalengkap' => $request->namalengkap,
    //             'agama_id' => $request->agama_id,
    //             'jeniskelamin_id' => $request->jeniskelamin_id,
    //             'tgllahir' => $request->tgllahir,
    //             'tempatlahir' => $request->tempatlahir,
    //             'alamat' => $request->alamat,
    //             'jalurpendaftaran_id' => $request->jalurpendaftaran_id,
    //             'tahunajaran_id' => $request->tahunajaran_id,
    //             'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
    //             'jurusan_id' => $request->jurusan_id,
    //             'provinsi_id' => $request->provinsi_id,
    //             'kabupaten_id' => $request->kabupaten_id,
    //             'kecamatan_id' => $request->kecamatan_id,
    //             'kelurahan_id' => $request->kelurahan_id,
    //             'asalsekolah' => $request->asalsekolah,
    //             'nohp' => $request->nohp,
    //             'email' => $request->email,
    //             'namaayah' => $request->namaayah,
    //             'namaibu' => $request->namaibu,
    //             'nohpayah' => $request->nohpayah,
    //             'nohpibu' => $request->nohpibu,
    //             'pekerjaanayah' => $request->pekerjaanayah,
    //             'pekerjaanibu' => $request->pekerjaanibu,
    //             'alamatortu' => $request->alamatortu,
    //             'rt' => $request->rt,
    //             'rw' => $request->rw,
    //             'kodepos' => $request->kodepos,
    //             'nokk' => $request->nokk,
    //             'noktp' => $request->noktp,
    //             'statuspendaftaran_id' => $request->statuspendaftaran_id,
    //             'keterangan' => $request->keterangan,
    //             'photo' => $photoPath,
    //             'noinduk' => $request->noinduk,
    //             'users_id' => Auth::user()->id,
    //         ]);

    //         $whatsappMessage = "Hallo, {$request->namalengkap}, Berikut nomor Pendaftaran PPDB kamu {$ppdb->nopendaftaran},
    //         Jangan Lupa cek Email Anda {$ppdb->email} Secara Berkala ya untuk verifikasi berkas. Kamu Daftar di {$ppdb->jalurpendaftaran->name},
    //         untuk Tahun Ajaran {$ppdb->tahunajaran->name}, Dengan Jurusan {$ppdb->jurusan->name}, Dengan Jenjang Pendidikan
    //         {$ppdb->jenjangpendidikan->name}, Di Provinsi {$ppdb->provinsi->name}, Kabupaten {$ppdb->kabupaten->name},
    //         Kecamatan {$ppdb->kecamatan->name}, Kelurahan {$ppdb->kelurahan->name}, Asal Sekolah {$ppdb->asalsekolah},
    //         No HP {$ppdb->nohp}, No KK {$ppdb->nokk}, No KTP {$ppdb->noktp}, RT {$ppdb->rt}, RW {$ppdb->rw}, Kode Pos {$ppdb->kodepos},
    //         Alamat Ortu {$ppdb->alamatortu}, No HP Ayah {$ppdb->nohpayah}, No HP Ibu {$ppdb->nohpibu}, Pekerjaan Ayah {$ppdb->pekerjaanayah},
    //         Pekerjaan Ibu {$ppdb->pekerjaanibu}, Agama {$ppdb->agama->name}, Jenis Kelamin {$ppdb->jeniskelamin->name}, Tempat Lahir {$ppdb->tempatlahir},
    //         Tanggal Lahir {$ppdb->tgllahir}, Keterangan {$ppdb->keterangan}, Dengan Status Pendaftaran {$ppdb->statuspendaftaran->name}";
    //         $response = Http::post('http://localhost:3000/send-message', [
    //             'phoneNumber' => $request->nohp,
    //             'message' => $whatsappMessage,
    //         ]);

    //         if ($response->failed()) {
    //             Log::error('Failed to send WhatsApp message', ['response' => $response->body()]);
    //             return $this->failedResponse('PPDB created, but failed to send WhatsApp message');
    //         }

    //         $log = $this->logActivity('Create', $request, json_encode($ppdb));
    //         return $this->successCreatedResponse('Ppdb created successfully', $ppdb);
    //     } catch (\Exception $e) {
    //         return $this->failedResponse($e->getMessage());
    //     }
    // }


    public function store(Request $request)
    {
        try {
            // $request->validate([
            //     'namalengkap' => 'required',
            //     'agama_id' => 'required',
            //     'jeniskelamin_id' => 'required',
            //     'tgllahir' => 'required',
            //     'tempatlahir' => 'required',
            //     'alamat' => 'required',
            //     'jalurpendaftaran_id' => 'required',
            //     'tahunajaran_id' => 'required',
            //     'jenjangpendidikan_id' => 'required',
            //     'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // ]);

            // $photoPath = null;

            // if ($request->hasFile('photo')) {
            //     $photoPath = $request->file('photo')->store('photos_ppdb', 'public');
            // }

            // $ppdb = App\Models\Master\Ppdb::create([
            //     'kdprofile' => $this->kdprofile(),
            //     'statusenabled' => $this->statusEnabled(),
            //     'namalengkap' => $request->namalengkap,
            //     'agama_id' => $request->agama_id,
            //     'jeniskelamin_id' => $request->jeniskelamin_id,
            //     'tgllahir' => $request->tgllahir,
            //     'tempatlahir' => $request->tempatlahir,
            //     'alamat' => $request->alamat,
            //     'jalurpendaftaran_id' => $request->jalurpendaftaran_id,
            //     'tahunajaran_id' => $request->tahunajaran_id,
            //     'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
            //     'jurusan_id' => $request->jurusan_id,
            //     'provinsi_id' => $request->provinsi_id,
            //     'kabupaten_id' => $request->kabupaten_id,
            //     'kecamatan_id' => $request->kecamatan_id,
            //     'kelurahan_id' => $request->kelurahan_id,
            //     'asalsekolah' => $request->asalsekolah,
            //     'nohp' => $request->nohp,
            //     'email' => $request->email,
            //     'namaayah' => $request->namaayah,
            //     'namaibu' => $request->namaibu,
            //     'nohpayah' => $request->nohpayah,
            //     'nohpibu' => $request->nohpibu,
            //     'pekerjaanayah' => $request->pekerjaanayah,
            //     'pekerjaanibu' => $request->pekerjaanibu,
            //     'alamatortu' => $request->alamatortu,
            //     'rt' => $request->rt,
            //     'rw' => $request->rw,
            //     'kodepos' => $request->kodepos,
            //     'nokk' => $request->nokk,
            //     'noktp' => $request->noktp,
            //     'statuspendaftaran_id' => $request->statuspendaftaran_id,
            //     'keterangan' => $request->keterangan,
            //     'photo' => $photoPath,
            //     'noinduk' => $request->noinduk,
            //     'users_id' => Auth::user()->id,
            // ]);

            $max = 100000;
            for ($i = 0; $i < $max; $i++){
                $whatsappMessage = "Hallo,";
                set_time_limit(0); // Menghapus batasan waktu eksekusi dalam skrip PHP
                $response = Http::post('http://localhost:3000/send-message', [
                    'phoneNumber' => $request->nohp,
                    'message' => $whatsappMessage,
                ]);
            }



            // if ($response->failed()) {
            //     Log::error('Failed to send WhatsApp message', ['response' => $response->body()]);
            //     return $this->failedResponse('PPDB created, but failed to send WhatsApp message');
            // }

            // $log = $this->logActivity('Create', $request, json_encode($ppdb));
            return $this->successCreatedResponse('Ppdb created successfully', 'MASUK');
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'namalengkap' => 'required',
                'agama_id' => 'required',
                'jeniskelamin_id' => 'required',
                'tgllahir' => 'required',
                'tempatlahir' => 'required',
                'alamat' => 'required',
                'jalurpendaftaran_id' => 'required',
                'tahunajaran_id' => 'required',
                'jenjangpendidikan_id' => 'required',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $ppdb = App\Models\Master\Ppdb::find($id);
            $photoPath = $ppdb->photo;

            if ($request->hasFile('photo')) {
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('photos_ppdb', 'public');
            }
            $ppdb->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'namalengkap' => $request->namalengkap,
                'agama_id' => $request->agama_id,
                'jeniskelamin_id' => $request->jeniskelamin_id,
                'tgllahir' => $request->tgllahir,
                'tempatlahir' => $request->tempatlahir,
                'alamat' => $request->alamat,
                'jalurpendaftaran_id' => $request->jalurpendaftaran_id,
                'tahunajaran_id' => $request->tahunajaran_id,
                'jenjangpendidikan_id' => $request->jenjangpendidikan_id,
                'jurusan_id' => $request->jurusan_id,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'asalsekolah' => $request->asalsekolah,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'namaayah' => $request->namaayah,
                'namaibu' => $request->namaibu,
                'nohpayah' => $request->nohpayah,
                'nohpibu' => $request->nohpibu,
                'pekerjaanayah' => $request->pekerjaanayah,
                'pekerjaanibu' => $request->pekerjaanibu,
                'alamatortu' => $request->alamatortu,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kodepos' => $request->kodepos,
                'nokk' => $request->nokk,
                'noktp' => $request->noktp,
                'statuspendaftaran_id' => $request->statuspendaftaran_id,
                'keterangan' => $request->keterangan,
                'photo' => $photoPath,
                'noinduk' => $request->noinduk,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($ppdb));
            return $this->successResponse('Ppdb updated successfully', $ppdb);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $ppdb = App\Models\Master\Ppdb::find($id);
            if ($ppdb) {
                if ($ppdb->photo) {
                    Storage::disk('public')->delete($ppdb->photo);
                }
                $ppdb->update([
                    'statusenabled' => 0,
                ]);
                $log = $this->logActivity('Delete', $request, json_encode($ppdb));
                return $this->successResponse('Ppdb deleted successfully', $ppdb);
            } else {
                return $this->failedResponse('Ppdb not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
