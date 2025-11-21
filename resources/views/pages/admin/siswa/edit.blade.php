@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0" style="color: #fff">✏️ Edit Data Siswa</h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- UNIT --}}
                        <div class="form-floating mb-3">
                            <select class="form-select @error('unit_id') is-invalid @enderror"
                                    name="unit_id">
                                <option value="">Tidak ada unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" 
                                        {{ old('unit_id', $siswa->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Unit</label>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   name="nama" value="{{ old('nama', $siswa->nama) }}" placeholder="Nama Siswa">
                            <label>Nama Siswa</label>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KELAS --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                   name="kelas" value="{{ old('kelas', $siswa->kelas) }}" placeholder="Kelas">
                            <label>Kelas</label>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- USERNAME --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username', $siswa->username) }}" placeholder="Username">
                            <label>Username</label>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <span style="color: red">*)Silahkan isi jika ingin mengganti, jika tidak kosongkan saja</span>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                   name="password" value="{{ old('password') }}" placeholder="-- Ubah Jika Ingin Mengganti Password --">
                            <label>Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary px-4">
                                Kembali
                            </a>

                            <button class="btn btn-primary px-4">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
