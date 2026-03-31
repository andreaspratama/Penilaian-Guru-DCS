@extends('layouts.admin')

@section('content')

<style>
    .rekap-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        border: 1px solid #eef0f5;
    }

    .rekap-title {
        font-weight: 700;
        font-size: 24px;
        margin-bottom: 8px;
    }

    .rekap-info {
        font-size: 15px;
        color: #555;
    }

    /* Tabel elegan */
    .table-elegant {
        border-collapse: separate !important;
        border-spacing: 0;
        overflow: hidden;
        border-radius: 12px;
    }

    .table-elegant thead tr {
        background: #0d6efd;
        color: white;
    }

    .table-elegant th {
        padding: 14px;
        font-size: 14px;
        font-weight: 600;
        border: none !important;
        text-align: center;
    }

    .table-elegant tbody tr {
        background: #ffffff;
        transition: 0.2s;
    }

    .table-elegant tbody tr:hover {
        background: #f4f8ff;
    }

    .table-elegant td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #e6e8ec !important;
        vertical-align: middle;
    }

    .col-pertanyaan {
        width: 38%;
        font-weight: 500;
    }

    .badge-nilai {
        background: #e8f2ff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 13px;
        display: inline-block;
        color: #0d6efd;
    }

    .detail-siswa div {
        margin-bottom: 2px;
    }
</style>

<div class="container py-4">

    <div class="rekap-card">

        <h3 class="rekap-title">
            Rekap Penilaian Guru: {{ $header->guru->nama }}
        </h3>

        <p class="rekap-info">
            Unit: <b>{{ $header->unit }}</b> |
            Kelas: <b>{{ $header->kelas }}</b>
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-elegant">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th class="col-pertanyaan">Pertanyaan</th>
                        <th>Jumlah Pengisi</th>
                        <th>Total Nilai</th>
                        <th>Rata-rata</th>
                        <th>Detail Siswa</th>
                    </tr>
                </thead>

                <tbody>
                    @for ($i = 1; $i <= 9; $i++)
                    <tr>
                        <td class="text-center fw-bold">{{ $i }}</td>

                        <td class="col-pertanyaan">
                            Pertanyaan {{ $i }}
                        </td>

                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 fw-semibold">
                                {{ $rekap[$i]['jumlah_pengisi'] }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-warning-subtle text-warning px-3 py-2 fw-semibold">
                                {{ $rekap[$i]['total_nilai'] }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success px-3 py-2 fw-semibold">
                                {{ $rekap[$i]['rata_rata'] }}
                            </span>
                        </td>

                        <td class="detail-siswa">
                            @foreach ($rekap[$i]['detail_siswa'] as $s)
                                <div>- {{ $s['nama'] }} <span class="badge-nilai">({{ $s['nilai'] }})</span></div>
                            @endforeach
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
