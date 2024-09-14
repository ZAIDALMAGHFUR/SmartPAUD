<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App;


class JawabanTugasSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $jawabanTugasSiswas = Cache::remember('jawaban_tugas_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\JawabanTugasSiswa::with(['tugasSiswa', 'KelasSiswa', 'guru','jawabanTugasSiswaDetails'])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($jawabanTugasSiswas->isEmpty()) {
            return $this->failedResponse('Jawaban Tugas Siswa not found');
        } else {
            return $this->successResponse('Jawaban Tugas Siswa retrieved successfully', $jawabanTugasSiswas);
        }
    }

    public function show($id)
    {
        $jawabanTugasSiswa = App\Models\Master\JawabanTugasSiswa::with(['tugasSiswa', 'KelasSiswa', 'guru','jawabanTugasSiswaDetails'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($jawabanTugasSiswa) {
            return $this->successResponse('Jawaban Tugas Siswa retrieved successfully', $jawabanTugasSiswa);
        } else {
            return $this->failedResponse('Jawaban Tugas Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kelassiswa_id' => 'required|integer',
                'tugassiswa_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'tgljawab' => 'required|date',
                'details' => 'required|array',
                'details.*.tugassiswadetail_id' => 'required|integer',
                'details.*.jawabanpilihan' => 'nullable|string',
                'details.*.jawabanessay' => 'nullable|string',
                'details.*.iscorrect' => 'required|boolean',
            ]);

            $jawabanTugasSiswa = App\Models\Master\JawabanTugasSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'kelassiswa_id' => $validatedData['kelassiswa_id'],
                'tugassiswa_id' => $validatedData['tugassiswa_id'],
                'guru_id' => $validatedData['guru_id'],
                'tgljawab' => $validatedData['tgljawab'],
                'nilaiakhir' => 0,
            ]);

            $totalNilai = 0;
            $jumlahJawabanBenar = 0;

            foreach ($validatedData['details'] as $detail) {
                $nilai = $detail['iscorrect'] ? 100 : 0;
                $totalNilai += $nilai;
                if ($detail['iscorrect']) {
                    $jumlahJawabanBenar++;
                }

                App\Models\Master\JawabanTugasSiswaDetail::create([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'jawabantugassiswa_id' => $jawabanTugasSiswa->id,
                    'tugassiswadetail_id' => $detail['tugassiswadetail_id'],
                    'jawabanpilihan' => $detail['jawabanpilihan'] ?? '',
                    'jawabanessay' => $detail['jawabanessay'] ?? '',
                    'iscorrect' => $detail['iscorrect'],
                    'nilai' => $nilai,
                ]);
            }

            $jawabanTugasSiswa->update([
                'nilaiakhir' => $totalNilai / max(1, count($validatedData['details'])),
            ]);

            $log = $this->logActivity('Create', $request, json_encode($jawabanTugasSiswa));
            return $this->successResponse('Jawaban Tugas Siswa created successfully', $jawabanTugasSiswa);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $jawabanTugasSiswa = App\Models\Master\JawabanTugasSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$jawabanTugasSiswa) {
                return $this->failedResponse('Jawaban Tugas Siswa not found');
            }

            $validatedData = $request->validate([
                'kelassiswa_id' => 'required|integer',
                'tugassiswa_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'tgljawab' => 'required|date',
                'details' => 'required|array',
                'details.*.tugassiswadetail_id' => 'required|integer',
                'details.*.jawabanpilihan' => 'nullable|string',
                'details.*.jawabanessay' => 'nullable|string',
                'details.*.iscorrect' => 'required|boolean',
            ]);

            $jawabanTugasSiswa->update([
                'kelassiswa_id' => $validatedData['kelassiswa_id'],
                'tugassiswa_id' => $validatedData['tugassiswa_id'],
                'guru_id' => $validatedData['guru_id'],
                'tgljawab' => $validatedData['tgljawab'],
            ]);

            $totalNilai = 0;
            $jumlahJawabanBenar = 0;

            App\Models\Master\JawabanTugasSiswaDetail::where('jawabantugassiswa_id', $jawabanTugasSiswa->id)->delete();

            foreach ($validatedData['details'] as $detail) {
                $nilai = $detail['iscorrect'] ? 100 : 0;
                $totalNilai += $nilai;
                if ($detail['iscorrect']) {
                    $jumlahJawabanBenar++;
                }

                App\Models\Master\JawabanTugasSiswaDetail::create([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'jawabantugassiswa_id' => $jawabanTugasSiswa->id,
                    'tugassiswadetail_id' => $detail['tugassiswadetail_id'],
                    'jawabanpilihan' => $detail['jawabanpilihan'] ?? '',
                    'jawabanessay' => $detail['jawabanessay'] ?? '',
                    'iscorrect' => $detail['iscorrect'],
                    'nilai' => $nilai,
                ]);
            }

            $jawabanTugasSiswa->update([
                'nilaiakhir' => $totalNilai / max(1, count($validatedData['details'])),
            ]);

            $log = $this->logActivity('Update', $request, json_encode($jawabanTugasSiswa));
            return $this->successResponse('Jawaban Tugas Siswa updated successfully', $jawabanTugasSiswa);
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage());
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $jawabanTugasSiswa = App\Models\Master\JawabanTugasSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$jawabanTugasSiswa) {
                return $this->failedResponse('Jawaban Tugas Siswa not found');
            }

            $jawabanTugasSiswa->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($jawabanTugasSiswa));
            return $this->successResponse('Jawaban Tugas Siswa deleted successfully', $jawabanTugasSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }
}
