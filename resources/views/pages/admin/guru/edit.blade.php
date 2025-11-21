@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0" style="color: #fff">✏️ Edit Data Guru</h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- UNIT --}}
                        <div class="form-floating mb-3">
                            <select class="form-select @error('unit_id') is-invalid @enderror"
                                    name="unit_id">
                                <option value="">Tidak ada unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" 
                                        {{ old('unit_id', $guru->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Unit (Opsional)</label>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   name="nama" value="{{ old('nama', $guru->nama) }}" placeholder="Nama Guru">
                            <label>Nama Guru</label>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KELAS --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                   name="kelas" value="{{ old('kelas', $guru->kelas) }}" placeholder="Kelas">
                            <label>Kelas</label>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- MAPEL --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('mapel') is-invalid @enderror"
                                   name="mapel" value="{{ old('mapel', $guru->mapel) }}" placeholder="Mapel">
                            <label>Mapel</label>
                            @error('mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('guru.index') }}" class="btn btn-secondary px-4">
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
