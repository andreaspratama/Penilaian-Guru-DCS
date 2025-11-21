<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Unit::query(); // lebih baik pakai query(), bukan all()

            return datatables()->of($data)
                ->addIndexColumn() // <-- INI YANG BIKIN NO URUT
                ->addColumn('aksi', function ($row) {
                    $edit = '
                        <a href="'.route('unit.edit', $row->id).'" 
                        class="btn-modern btn-edit">
                            ✏️ Edit
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn-modern btn-delete btn-hapus">
                            🗑️ Hapus
                        </button>';

                    return $edit . ' ' . $hapus;

                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('pages.admin.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required|string|max:100',
        ]);

        Unit::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('unit.index')
                        ->with('success', 'Unit berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Unit::findOrFail($id);

        return view('pages.admin.unit.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $unit = Unit::findOrFail($id);

        $unit->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('unit.index')
                        ->with('success', 'Unit berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Unit berhasil dihapus'
        ]);
    }
}
