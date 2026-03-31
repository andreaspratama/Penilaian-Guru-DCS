<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Pertanyaansiswa;

class PertanyaanController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        // ✅ Ambil guru yang sudah dinilai siswa ini
        $sudah = Pertanyaansiswa::where('siswa_id', $siswa->id)
                        ->pluck('guru_id')
                        ->toArray();

        // ✅ Ambil guru berdasarkan kelas siswa + belum dinilai
        $gurus = Guru::with('mapelKelas')
            ->whereHas('mapelKelas', function ($query) use ($siswa) {
                $query->where('kelas', $siswa->kelas);
            })
            ->whereNotIn('id', $sudah)
            ->get();

        return view('pages.siswa.index', compact('gurus'));
    }

    public function penilaianForm(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id'
        ]);

        $guru = Guru::find($request->guru_id);
        $siswa = auth()->user()->siswa;

        return view('pages.siswa.pertanyaanSiswa', compact('guru', 'siswa'));
    }

    public function penilaianStore(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'pertanyaan1' => 'required',
            'pertanyaan2' => 'required',
            'pertanyaan3' => 'required',
            'pertanyaan4' => 'required',
            'pertanyaan5' => 'required',
            'pertanyaan6' => 'required',
            'pertanyaan7' => 'required',
            'pertanyaan8' => 'required',
        ]);

        $siswa = auth()->user()->siswa;

        Pertanyaansiswa::create([
            'siswa_id' => $siswa->id,
            'guru_id' => $request->guru_id,
            'kelas' => $siswa->kelas,
            'unit' => $siswa->unit->nama,
            'pertanyaan1' => $request->pertanyaan1,
            'pertanyaan2' => $request->pertanyaan2,
            'pertanyaan3' => $request->pertanyaan3,
            'pertanyaan4' => $request->pertanyaan4,
            'pertanyaan5' => $request->pertanyaan5,
            'pertanyaan6' => $request->pertanyaan6,
            'pertanyaan7' => $request->pertanyaan7,
            'pertanyaan8' => $request->pertanyaan8,
            'pertanyaan9' => $request->pertanyaan9, // optional
            'tanggal_isi' => now()->toDateString(),
            'waktu_isi' => now()->toTimeString(),
        ]);

        return redirect()
            ->route('dashboardSiswa')
            ->with('success', 'Penilaian berhasil disimpan!');
    }

    public function allResponse(Request $request)
    {
        if ($request->ajax()) {

            $data = Pertanyaansiswa::orderBy('id', 'DESC')->get();

            return datatables()->of($data)
                ->addIndexColumn()

                // tampilkan UNIT
                ->addColumn('unit_nama', function ($row) {
                    return $row->unit ?? '-';
                })

                // tampilkan NAMA SISWA
                ->addColumn('siswa_nama', function ($row) {
                    return $row->siswa->nama ?? '-';
                })

                // tampilkan NAMA GURU
                ->addColumn('guru_nama', function ($row) {
                    return $row->guru->nama ?? '-';
                })

                ->addColumn('aksi', function ($row) {
                    $detail = '
                        <a href="'.route('responseDetail', $row->id).'"
                        class="btn btn-sm btn-info rounded-pill px-3">
                        👁️ Detail
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn btn-sm btn-danger rounded-pill px-3 btn-hapus">
                        🗑️ Hapus
                        </button>';

                    return $detail . ' ' . $hapus;
                })

                ->rawColumns(['unit_nama', 'siswa_nama', 'guru_nama', 'aksi'])
                ->make(true);
        }

        return view('pages.admin.response.index');
    }

    public function responseDetail($id)
    {
        $data = Pertanyaansiswa::with(['siswa', 'guru'])->findOrFail($id);

        return view('pages.admin.response.detail', compact('data'));
    }

    public function sortBySma(Request $request)
    {
        if ($request->ajax()) {

            // Ambil data siswa yang unitnya SMA saja
            $data = Pertanyaansiswa::where('unit', 'Senior High School')
                    ->orderBy('id', 'DESC')
                    ->get();

            return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('unit_nama', function ($row) {
                    return $row->unit ?? '-';
                })
                ->addColumn('siswa_nama', function ($row) {
                    return $row->siswa->nama ?? '-';
                })
                ->addColumn('guru_nama', function ($row) {
                    return $row->guru->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $detail = '
                        <a href="'.route('responseDetail', $row->id).'"
                        class="btn btn-sm btn-info rounded-pill px-3">
                        👁️ Detail
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn btn-sm btn-danger rounded-pill px-3 btn-hapus">
                        🗑️ Hapus
                        </button>';

                    return $detail . ' ' . $hapus;
                })

                ->rawColumns(['unit_nama', 'siswa_nama', 'guru_nama', 'aksi'])
                ->make(true);
        }

        return view('pages.admin.response.sortBySma');
    }

    public function sortBySmp(Request $request)
    {
        if ($request->ajax()) {

            // Ambil data siswa yang unitnya SMA saja
            $data = Pertanyaansiswa::where('unit', 'Junior High School')
                    ->orderBy('id', 'DESC')
                    ->get();

            return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('unit_nama', function ($row) {
                    return $row->unit ?? '-';
                })
                ->addColumn('siswa_nama', function ($row) {
                    return $row->siswa->nama ?? '-';
                })
                ->addColumn('guru_nama', function ($row) {
                    return $row->guru->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $detail = '
                        <a href="'.url('admin/responseDetailPerSiswa/'.$row->id).'"
                        class="btn btn-sm btn-info rounded-pill px-3">
                        👁️ Detail
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn btn-sm btn-danger rounded-pill px-3 btn-hapus">
                        🗑️ Hapus
                        </button>';

                    return $detail . ' ' . $hapus;
                })

                ->rawColumns(['unit_nama', 'siswa_nama', 'guru_nama', 'aksi'])
                ->make(true);
        }

        return view('pages.admin.response.sortBySmp');
    }

    public function sortByEle(Request $request)
    {
        if ($request->ajax()) {

            // Ambil data siswa yang unitnya Elementary saja
            $data = Guru::where('unit_id', 1)
                    ->orderBy('id', 'DESC')
                    ->get();

            return datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('unit_nama', function ($row) {
                    return $row->unit->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $ps = Pertanyaansiswa::where('guru_id', $row->id)->first();

                    if (!$ps) {
                        return '<button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>
                                Tidak Ada Data
                                </button>';
                    }
                    $detail = '
                        <a href="'.route('detailPerSiswa', $ps->id).'"
                        class="btn btn-sm btn-info rounded-pill px-3">
                        👁️ Detail
                        </a>';

                    $hapus = '
                        <button data-id="'.$row->id.'"
                                class="btn btn-sm btn-danger rounded-pill px-3 btn-hapus">
                        🗑️ Hapus
                        </button>';

                    return $detail . ' ' . $hapus;
                })

                ->rawColumns(['unit_nama', 'aksi'])
                ->make(true);
        }

        return view('pages.admin.response.sortByEle');
    }

    public function detailPerSiswa($id)
    {
        $header = Pertanyaansiswa::findOrFail($id);

        $datas = Pertanyaansiswa::where('guru_id', $header->guru_id)
            ->where('kelas', $header->kelas)
            ->where('unit', $header->unit)
            ->get();

        $rekap = [];

        for ($i = 1; $i <= 9; $i++) {

            $kolom = "pertanyaan" . $i;

            $nilai = $datas->pluck($kolom)
                ->filter(function ($v) {
                    return is_numeric($v);
                })
                ->map(function ($v) {
                    return (int) $v;
                });

            $rekap[$i] = [
                'jumlah_pengisi' => $nilai->count(),
                'total_nilai' => $nilai->sum(),
                'rata_rata' => $nilai->count() > 0 ? round($nilai->avg(), 2) : 0,
                'detail_siswa' => $datas->map(function ($d) use ($kolom) {
                    return [
                        'nama' => $d->siswa->nama ?? '-',
                        'nilai' => is_numeric($d->$kolom) ? (int)$d->$kolom : 0
                    ];
                })
            ];
        }

        return view('pages.admin.response.detailPerSiswa', compact('header','rekap'));
    }
}
