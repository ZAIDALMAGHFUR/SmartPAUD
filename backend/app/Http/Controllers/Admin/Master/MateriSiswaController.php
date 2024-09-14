<?php

namespace App\Http\Controllers\Admin\Master;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MateriSiswaController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $perPage = 100;
        $materiSiswas = Cache::remember('materi_siswa_list_' . $this->kdprofile(), 60, function () use ($perPage) {
            return App\Models\Master\MateriSiswa::with(['kelas', 'tahunAjaran', 'guru', 'mataPelajaran'])
                ->where('statusenabled', $this->statusEnabled())
                ->where('kdprofile', $this->kdprofile())
                ->paginate($perPage);
        });

        if ($materiSiswas->isEmpty()) {
            return $this->failedResponse('Materi Siswa not found');
        } else {
            return $this->successResponse('Materi Siswa retrieved successfully', $materiSiswas);
        }
    }

    public function show($id)
    {
        $materiSiswa = App\Models\Master\MateriSiswa::with(['kelas', 'tahunAjaran', 'guru', 'mataPelajaran'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->find($id);

        if ($materiSiswa) {
            return $this->successResponse('Materi Siswa retrieved successfully', $materiSiswa);
        } else {
            return $this->failedResponse('Materi Siswa not found');
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
            ]);

            if ($validatedData['type'] === 'file') {
                $request->validate([
                    'file_or_link' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx',
                ]);
                $file = $request->file('file_or_link');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files/materi_siswa', $fileName, 'public');
                $validatedData['file_or_link'] = $path;
            }else {
                $validatedData['file_or_link'] = $request->validate([
                    'file_or_link' => 'required|string',
                ])['file_or_link'];
            }

            $materiSiswa = App\Models\Master\MateriSiswa::create([
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

            $log = $this->logActivity('Create', $request, json_encode($materiSiswa));

            return response()->json(['message' => 'Materi Siswa created successfully', 'data' => $materiSiswa], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'type' => 'required|in:file,link',
                'kelas_id' => 'required|integer',
                'tahunajaran_id' => 'required|integer',
                'guru_id' => 'required|integer',
                'matapelajaran_id' => 'required|integer',
            ]);

            $materiSiswa = App\Models\Master\MateriSiswa::findOrFail($id);

            if ($request->type === 'file') {
                if ($request->hasFile('file_or_link')) {
                    $request->validate(['file_or_link' => 'file_or_link|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx']);

                    if ($materiSiswa->file_or_link && Storage::disk('public')->exists($materiSiswa->file_or_link)) {
                        Storage::disk('public')->delete($materiSiswa->file_or_link);
                    }

                    $file = $request->file('file_or_link');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('files/materi_siswa', $fileName, 'public');
                    $materiSiswa->file_or_link = $path;
                }
            } else {
                $validatedData['file_or_link'] = $request->validate([
                    'file_or_link' => 'required|string'
                ])['file_or_link'];
                $materiSiswa->file_or_link = $validatedData['file_or_link'];
            }

            $materiSiswa->update([
                'kdprofile' => $this->kdprofile(),
                'statusenabled' => $this->statusEnabled(),
                'name' => $validatedData['name'],
                'kelas_id' => $validatedData['kelas_id'],
                'tahunajaran_id' => $validatedData['tahunajaran_id'],
                'guru_id' => $validatedData['guru_id'],
                'matapelajaran_id' => $validatedData['matapelajaran_id'],
            ]);

            $log = $this->logActivity('Update', $request, json_encode($materiSiswa));

            return $this->successResponse('Materi Siswa updated successfully', $materiSiswa);
        } catch (\Exception $e) {
            return $this->failedResponse($e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $materiSiswa = App\Models\Master\MateriSiswa::find($id);
        if ($materiSiswa) {
            $materiSiswa->update([
                'statusenabled' => 0,
            ]);
            $log = $this->logActivity('Delete', $request, json_encode($materiSiswa));
            return $this->successResponse('Materi Siswa deleted successfully', $materiSiswa);
        } else {
            return $this->failedResponse('Materi Siswa not found');
        }
    }
}
