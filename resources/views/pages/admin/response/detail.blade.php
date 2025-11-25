@extends('layouts.admin')

@section('content')
<div class="page-heading">

    <section class="section">

        <div class="card shadow border-0">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 fw-bold">Detail Penilaian</h4>
                    <span class="badge bg-primary px-3 py-2">
                        {{ $data->created_at->format('d M Y, H:i') }}
                    </span>
                </div>

                {{-- INFORMASI SINGKAT --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted">Nama Siswa</small>
                            <div class="fw-bold fs-5">{{ $data->siswa->nama }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted">Guru Dinilai</small>
                            <div class="fw-bold fs-5">{{ $data->guru->nama }} ({{ $data->guru->mapel }})</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted">Kelas</small>
                            <div class="fw-bold fs-5">{{ $data->kelas }}</div>
                        </div>
                    </div>
                </div>


                {{-- PERTANYAAN --}}
                <h5 class="fw-bold text-primary mb-3">Jawaban Penilaian</h5>

                <div class="list-group">

                    <div class="list-group-item py-3">
                        <strong>1. He/she can explain the lesson well in English</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan1 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>2. He/she speaks English with students in class</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan2 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>3. He/she speaks English with other teachers</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan3 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>4. I understand when he/she explains in English</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan4 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>5. I speak English with my friends in class</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan5 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>6. I speak English outside the classroom</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan6 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>7. I feel confident speaking English at school</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan7 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>8. My English has improved because I am a DCS student</strong>
                        <br>
                        <span class="badge bg-secondary mt-2">Jawaban: {{ $data->pertanyaan8 }}</span>
                    </div>

                    <div class="list-group-item py-3">
                        <strong>9. Student Suggestions / Feedback</strong>
                        <br>
                        <div class="mt-2 p-2 border rounded bg-light">
                            {{ $data->pertanyaan9 ?? '—' }}
                        </div>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 text-end">
                    <a href="{{ route('allResponse') }}" class="btn btn-secondary px-4">← Kembali</a>
                </div>

            </div>
        </div>

    </section>

</div>
@endsection
