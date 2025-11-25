<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika permintaan datang dari DataTables AJAX
        if ($request->ajax()) {

            $data = Siswa::with('unit')->orderBy('id', 'DESC'); // pakai query()

            return datatables()->of($data)
                ->addIndexColumn() // menambah nomor urut otomatis
                ->addColumn('unit_nama', function ($row) {
                    return $row->unit ? $row->unit->nama : '<span class="badge bg-danger">Unit tidak ada</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $edit = '
                        <a href="'.route('siswa.edit', $row->id).'"
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

        return view('pages.admin.siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('pages.admin.siswa.create', compact('units'));
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
            'username'   => 'required|string|max:255|unique:siswas,username|unique:users,email',
            'password'   => 'required|string|max:255',
        ]);

        // 1. Simpan user dulu
        $user = User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['username'], // username jadi login
            'password' => Hash::make($validated['password']),
            'role'     => 'siswa',
        ]);

        // 2. Simpan siswa dengan user_id
        $siswa = Siswa::create([
            'unit_id'  => $validated['unit_id'],
            'nama'     => $validated['nama'],
            'kelas'    => $validated['kelas'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'user_id'  => $user->id,   // ← INI PENTING
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa & akun login berhasil ditambahkan!');
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
        $siswa = Siswa::findOrFail($id);
        $units = Unit::orderBy('nama')->get();

        return view('pages.admin.siswa.edit', compact('siswa', 'units'));
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
            'kelas'  => 'nullable|string|max:30',
            'unit_id' => 'nullable|exists:units,id',
        ], [
            'nama.required' => 'Nama siswa wajib diisi.',
            'username.required' => 'Username siswa wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        // Ambil data siswa lama
        $siswa = Siswa::findOrFail($id);

        // UPDATE USER LOGIN (di tabel users)
        $user = User::where('email', $siswa->username)->first(); // email = username lama

        if ($user) {
            $user->update([
                'name'  => $request->nama,
                'email' => $request->username,
                'password' => $request->password 
                    ? Hash::make($request->password) 
                    : $user->password, // kalau password kosong, pakai yang lama
            ]);
        }

        // UPDATE DATA SISWA
        $siswa->update([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'username' => $request->username,
            'password' => $request->password ?: $siswa->password, 
            'unit_id' => $request->unit_id,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus user login berdasarkan username (email)
        User::where('email', $siswa->username)->delete();

        // Baru hapus siswa
        $siswa->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Siswa & user login berhasil dihapus'
        ]);
    }
}
