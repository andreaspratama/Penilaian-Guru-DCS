<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\GuruMapelKelas;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika permintaan datang dari DataTables AJAX
        if ($request->ajax()) {

            $data = Guru::with(['unit', 'mapelKelas'])->orderBy('id', 'DESC'); // pakai query()

            return datatables()->of($data)
                ->addIndexColumn() // menambah nomor urut otomatis
                ->addColumn('unit_nama', function ($row) {
                    return $row->unit ? $row->unit->nama : '<span class="badge bg-danger">Unit tidak ada</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $edit = '
                        <a href="'.route('guru.edit', $row->id).'"
                           class="btn btn-sm btn-warning rounded-pill px-3">
                           ✏️ Edit
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn btn-sm btn-danger rounded-pill px-3 btn-hapus">
                           🗑️ Hapus
                        </button>';

                    return $edit . ' ' . $hapus;
                })
                ->addColumn('mapel', function ($row) {
                    return $row->mapelKelas->pluck('mapel')->implode(', ');
                })
                ->addColumn('kelas', function ($row) {
                    return $row->mapelKelas->pluck('kelas')->implode(', ');
                })
                ->rawColumns(['unit_nama', 'aksi', 'mapel', 'kelas'])
                ->make(true);
        }

        return view('pages.admin.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('pages.admin.guru.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ VALIDASI
        $validated = $request->validate([
            'unit_id'   => 'required|exists:units,id',
            'nama'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:gurus,username|unique:users,email',
            'password'  => 'required|string|max:255',

            'mapel'     => 'required|array',
            'mapel.*'   => 'required|string|max:255',
            'kelas'     => 'required|array',
            'kelas.*'   => 'required|string|max:255',
        ]);

        // ✅ SIMPAN GURU
        $guru = Guru::create([
            'unit_id'  => $validated['unit_id'],
            'nama'     => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        // ✅ SIMPAN MULTI MAPEL & KELAS
        foreach ($validated['mapel'] as $key => $mapel) {

            // safety biar gak error index
            if (!isset($validated['kelas'][$key])) {
                continue;
            }

            GuruMapelKelas::create([
                'guru_id' => $guru->id,
                'mapel'   => $mapel,
                'kelas'   => $validated['kelas'][$key],
            ]);
        }

        // ✅ BUAT USER LOGIN
        User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role'     => 'guru',
        ]);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru & mapel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guru = Guru::with('mapelKelas')->findOrFail($id);
        $units = Unit::all();

        return view('pages.admin.guru.edit', compact('guru', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        // ✅ VALIDASI
        $validated = $request->validate([
            'unit_id'   => 'required|exists:units,id',
            'nama'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:gurus,username,' . $guru->id . '|unique:users,email,' . $guru->username . ',email',
            'password'  => 'nullable|string|min:6',

            'mapel'     => 'required|array',
            'mapel.*'   => 'required|string|max:255',
            'kelas'     => 'required|array',
            'kelas.*'   => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            // ✅ UPDATE DATA GURU
            $dataGuru = [
                'unit_id'  => $validated['unit_id'],
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
            ];

            // kalau password diisi
            if ($request->filled('password')) {
                $dataGuru['password'] = Hash::make($request->password);
            }

            $guru->update($dataGuru);

            // ✅ HAPUS MAPEL LAMA
            GuruMapelKelas::where('guru_id', $guru->id)->delete();

            // ✅ INSERT ULANG MAPEL & KELAS
            foreach ($validated['mapel'] as $key => $mapel) {

                if (!isset($validated['kelas'][$key])) continue;

                GuruMapelKelas::create([
                    'guru_id' => $guru->id,
                    'mapel'   => $mapel,
                    'kelas'   => $validated['kelas'][$key],
                ]);
            }

            // ✅ UPDATE USER LOGIN (SINKRON)
            $user = User::where('email', $guru->getOriginal('username'))->first();

            if ($user) {

                $dataUser = [
                    'name'  => $validated['nama'],
                    'email' => $validated['username'],
                ];

                if ($request->filled('password')) {
                    $dataUser['password'] = Hash::make($request->password);
                }

                $user->update($dataUser);
            }

            DB::commit();

            return redirect()
                ->route('guru.index')
                ->with('success', 'Data guru berhasil diupdate!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', 'Gagal update data!')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Unit berhasil dihapus'
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {

            Excel::import(new GuruImport, $request->file('file'));

            return back()->with('success', 'Import berhasil!');

        } catch (ValidationException $e) {

            $errors = [];

            foreach ($e->failures() as $failure) {
                $errors[] = "Baris ke-".$failure->row()." | ".$failure->errors()[0];
            }

            return back()->with('error', implode('<br>', $errors));

        } catch (\Throwable $e) {

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
