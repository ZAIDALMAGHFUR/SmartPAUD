<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App;

class TugasSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $tugasSiswas = Cache::remember('tugas_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\TugasSiswa::with(['kelas', 'tahunAjaran', 'guru', 'mataPelajaran','pertanyaan'])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($tugasSiswas->isEmpty()) {
            return $this->failedResponse('Tugas Siswa not found');
        } else {
            return $this->successResponse('Tugas Siswa retrieved successfully', $tugasSiswas);
        }
    }

    public function show($id)
    {
        $tugasSiswa = App\Models\Master\TugasSiswa::with(['kelas', 'tahunAjaran', 'guru', 'mataPelajaran','pertanyaan'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($tugasSiswa) {
            return $this->successResponse('Tugas Siswa retrieved successfully', $tugasSiswa);
        } else {
            return $this->failedResponse('Tugas Siswa not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'type' => 'required|in:file,link',
                'kelas_id' => 'required|integer',
                'tahunajaran_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'matapelajaran_id' => 'required|integer',
                'pertanyaan' => 'required|array',
                'pertanyaan.*.pertanyaan' => 'required|string',
                'pertanyaan.*.is_essay' => 'required|boolean',
                'pertanyaan.*.pilihanjawaban' => 'nullable|array',
                'pertanyaan.*.jawabanbenar' => 'nullable|string',
            ]);

            if ($validatedData['type'] === 'file') {
                $request->validate([
                    'file_or_link' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                ]);
                $file = $request->file('file_or_link');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files/tugas_siswa', $fileName, 'public');
                $validatedData['file_or_link'] = $path;
            } else {
                $validatedData['file_or_link'] = $request->validate([
                    'file_or_link' => 'required|string',
                ])['file_or_link'];
            }

            $tugasSiswa = App\Models\Master\TugasSiswa::create([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $validatedData['name'],
                'type' => $validatedData['type'],
                'file_or_link' => $validatedData['file_or_link'],
                'kelas_id' => $validatedData['kelas_id'],
                'tahunajaran_id' => $validatedData['tahunajaran_id'],
                'guru_id' => $validatedData['guru_id'],
                'matapelajaran_id' => $validatedData['matapelajaran_id'],
            ]);

            foreach ($validatedData['pertanyaan'] as $detail) {
                App\Models\Master\TugasSiswaDetail::create([
                    'kdprofile' => $this->kdprofile(),
                    'statusenabled' => $this->statusEnabled(),
                    'tugassiswa_id' => $tugasSiswa->id,
                    'pertanyaan' => $detail['pertanyaan'],
                    'is_essay' => $detail['is_essay'],
                    'pilihanjawaban' => $detail['is_essay'] ? null : json_encode($detail['pilihanjawaban']),
                    'jawabanbenar' => $detail['is_essay'] ? null : $detail['jawabanbenar'],
                    'jawaban_essay' => $detail['is_essay'] ? $detail['jawaban_essay'] ?? null : null,
                ]);
            }

            $log = $this->logActivity('Create', $request, json_encode($tugasSiswa));
            return $this->successResponse('Tugas Siswa created successfully', $tugasSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa failed to create');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tugasSiswa = App\Models\Master\TugasSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$tugasSiswa) {
                return $this->failedResponse('Tugas Siswa not found');
            }

            $validatedData = $request->validate([
                'name' => 'required|string',
                'type' => 'required|in:file,link',
                'kelas_id' => 'required|integer',
                'tahunajaran_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'matapelajaran_id' => 'required|integer',
                'pertanyaan' => 'nullable|array',
                'pertanyaan.*.id' => 'nullable|integer',
                'pertanyaan.*.pertanyaan' => 'required_with:pertanyaan|string',
                'pertanyaan.*.is_essay' => 'required_with:pertanyaan|boolean',
                'pertanyaan.*.pilihanjawaban' => 'nullable|array',
                'pertanyaan.*.jawabanbenar' => 'nullable|string',
            ]);

            if ($validatedData['type'] === 'file') {
                $request->validate([
                    'file_or_link' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                ]);
                $file = $request->file('file_or_link');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files/tugas_siswa', $fileName, 'public');
                $validatedData['file_or_link'] = $path;
            } else {
                $validatedData['file_or_link'] = $request->validate([
                    'file_or_link' => 'required|string',
                ])['file_or_link'];
            }

            $tugasSiswa->update([
                'name' => $validatedData['name'],
                'type' => $validatedData['type'],
                'file_or_link' => $validatedData['file_or_link'],
                'kelas_id' => $validatedData['kelas_id'],
                'tahunajaran_id' => $validatedData['tahunajaran_id'],
                'guru_id' => $validatedData['guru_id'],
                'matapelajaran_id' => $validatedData['matapelajaran_id'],
            ]);

            if (isset($validatedData['pertanyaan'])) {
                foreach ($validatedData['pertanyaan'] as $detail) {
                    if (isset($detail['id'])) {
                        $tugasSiswaDetail = App\Models\Master\TugasSiswaDetail::where('tugassiswa_id', $tugasSiswa->id)
                            ->where('id', $detail['id'])
                            ->first();

                        if ($tugasSiswaDetail) {
                            $tugasSiswaDetail->update([
                                'pertanyaan' => $detail['pertanyaan'],
                                'is_essay' => $detail['is_essay'],
                                'pilihanjawaban' => $detail['is_essay'] ? null : json_encode($detail['pilihanjawaban']),
                                'jawabanbenar' => $detail['is_essay'] ? null : $detail['jawabanbenar'],
                                'jawaban_essay' => $detail['is_essay'] ? $detail['jawaban_essay'] ?? null : null,
                            ]);
                        }
                    } else {
                        App\Models\Master\TugasSiswaDetail::create([
                            'kdprofile' => $this->kdprofile(),
                            'statusenabled' => $this->statusEnabled(),
                            'tugassiswa_id' => $tugasSiswa->id,
                            'pertanyaan' => $detail['pertanyaan'],
                            'is_essay' => $detail['is_essay'],
                            'pilihanjawaban' => $detail['is_essay'] ? null : json_encode($detail['pilihanjawaban']),
                            'jawabanbenar' => $detail['is_essay'] ? null : $detail['jawabanbenar'],
                            'jawaban_essay' => $detail['is_essay'] ? $detail['jawaban_essay'] ?? null : null,
                        ]);
                    }
                }
            }

            $log = $this->logActivity('Update', $request, json_encode($tugasSiswa));
            return $this->successResponse('Tugas Siswa updated successfully', $tugasSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa failed to update');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $tugasSiswa = App\Models\Master\TugasSiswa::where('kdprofile', $this->kdprofile())
                ->where('statusenabled', $this->statusEnabled())
                ->find($id);

            if (!$tugasSiswa) {
                return $this->failedResponse('Tugas Siswa not found');
            }

            $tugasSiswa->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($tugasSiswa));
            return $this->successResponse('Tugas Siswa deleted successfully', $tugasSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse('Tugas Siswa failed to delete');
        }
    }
}
