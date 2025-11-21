<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika permintaan datang dari DataTables AJAX
        if ($request->ajax()) {

            $data = Guru::with('unit')->orderBy('id', 'DESC'); // pakai query()

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
                ->rawColumns(['unit_nama', 'aksi'])
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
        // Validasi input
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'nama'    => 'required|string|max:255',
            'kelas'   => 'required|string|max:255',
            'mapel'   => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:gurus,username|unique:users,email',
            'password'   => 'required|string|max:255',
        ]);

        // Simpan siswa ke tabel siswa
        $guru = Guru::create([
            'unit_id'  => $validated['unit_id'],
            'nama'     => $validated['nama'],
            'kelas'    => $validated['kelas'],
            'mapel'    => $validated['mapel'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']), // simpan password hashed
        ]);

        // Tambahkan ke tabel users untuk login
        User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['username'], // langsung pakai username sebagai email
            'password' => Hash::make($validated['password']),
            'role'     => 'guru',
        ]);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru & akun login berhasil ditambahkan!');
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
        $guru = Guru::findOrFail($id);
        $units = Unit::orderBy('nama')->get();

        return view('pages.admin.guru.edit', compact('guru', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'password' => 'nullable|string|max:100',
            'mapel'  => 'nullable|string|max:30',
            'kelas'  => 'nullable|string|max:30',
            'unit_id' => 'nullable|exists:units,id',
        ], [
            'nama.required' => 'Nama guru wajib diisi.',
            'username.required' => 'Username guru wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'mapel.required' => 'Mapel wajib diisi.',
        ]);

        // Ambil data guru lama
        $guru = Guru::findOrFail($id);

        // UPDATE USER LOGIN (di tabel users)
        $user = User::where('email', $guru->username)->first(); // email = username lama

        if ($user) {
            $user->update([
                'name'  => $request->nama,
                'email' => $request->username,
                'password' => $request->password 
                    ? Hash::make($request->password) 
                    : $user->password, // kalau password kosong, pakai yang lama
            ]);
        }

        // UPDATE DATA GURU
        $guru->update([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'username' => $request->username,
            'mapel' => $request->mapel,
            'password' => $request->password ?: $guru->password, 
            'unit_id' => $request->unit_id,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui!');
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
}
