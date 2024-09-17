<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RaportSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $raports = App\Models\Master\RaportSiswa::with(['kelassiswa','kelassiswa.siswa','kelas','tahunajaran','guru','matapelajaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($raports->isEmpty()) {
            return $this->failedResponse('Raport siswa not found');
        } else {
            return $this->successResponse('Raport siswa retrieved successfully', $raports);
        }
    }

    public function show($id)
    {
        try {
            $raport = App\Models\Master\RaportSiswa::with(['kelassiswa','kelassiswa.siswa','kelas','tahunajaran','guru','matapelajaran'])->findOrFail($id);
            return $this->successResponse('Raport siswa retrieved successfully', $raport);
        } catch (ModelNotFoundException $e) {
            return $this->failedResponse('Raport siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kelassiswa_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'jumlahkdpengetahuan' => 'required',
                'nilaipengetahuan' => 'required',
                'predikatpengetahuan' => 'required',
                'jumlahkdketerampilan' => 'required',
                'nilaiketerampilan' => 'required',
                'predikatketerampilan' => 'required',
                'ratarata' => 'required',
                'catatanwalikelas' => 'required',
                'tanggapanorangtua' => 'required',
            ]);

            $raport = App\Models\Master\RaportSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'kelassiswa_id' => $request->kelassiswa_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
                'guru_id' => $request->guru_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'jumlahkdpengetahuan' => $request->jumlahkdpengetahuan,
                'nilaipengetahuan' => $request->nilaipengetahuan,
                'predikatpengetahuan' => $request->predikatpengetahuan,
                'jumlahkdketerampilan' => $request->jumlahkdketerampilan,
                'nilaiketerampilan' => $request->nilaiketerampilan,
                'predikatketerampilan' => $request->predikatketerampilan,
                'ratarata' => $request->ratarata,
                'catatanwalikelas' => $request->catatanwalikelas,
                'tanggapanorangtua' => $request->tanggapanorangtua,
            ]);

            $log = $this->logActivity('Create', $request, json_encode($raport));
            return $this->successCreatedResponse('Raport siswa created successfully', $raport);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'kelassiswa_id' => 'required',
                'kelas_id' => 'required',
                'tahunajaran_id' => 'required',
                'guru_id' => 'required',
                'matapelajaran_id' => 'required',
                'jumlahkdpengetahuan' => 'required',
                'nilaipengetahuan' => 'required',
                'predikatpengetahuan' => 'required',
                'jumlahkdketerampilan' => 'required',
                'nilaiketerampilan' => 'required',
                'predikatketerampilan' => 'required',
                'ratarata' => 'required',
                'catatanwalikelas' => 'required',
                'tanggapanorangtua' => 'required',
            ]);

            $raport = App\Models\Master\RaportSiswa::with(['kelassiswa','kelassiswa.siswa','kelas','tahunajaran','guru','matapelajaran'])->findOrFail($id);
            $raport->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'kelassiswa_id' => $request->kelassiswa_id,
                'kelas_id' => $request->kelas_id,
                'tahunajaran_id' => $request->tahunajaran_id,
                'guru_id' => $request->guru_id,
                'matapelajaran_id' => $request->matapelajaran_id,
                'jumlahkdpengetahuan' => $request->jumlahkdpengetahuan,
                'nilaipengetahuan' => $request->nilaipengetahuan,
                'predikatpengetahuan' => $request->predikatpengetahuan,
                'jumlahkdketerampilan' => $request->jumlahkdketerampilan,
                'nilaiketerampilan' => $request->nilaiketerampilan,
                'predikatketerampilan' => $request->predikatketerampilan,
                'ratarata' => $request->ratarata,
                'catatanwalikelas' => $request->catatanwalikelas,
                'tanggapanorangtua' => $request->tanggapanorangtua,
            ]);

            $log = $this->logActivity('Update', $request, json_encode($raport));
            return $this->successResponse('Raport siswa updated successfully', $raport);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $raport = App\Models\Master\RaportSiswa::findOrFail($id);
            $raport->update([
                'statusenabled' => false
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($raport));
            return $this->successResponse('Raport siswa deleted successfully', $raport);
        } catch (ModelNotFoundException $e) {
            return $this->failedResponse('Raport siswa not found');
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
