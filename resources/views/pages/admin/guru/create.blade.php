@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0" style="color: #fff">✨ Tambah Data Guru</h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('guru.store') }}" method="POST">
                        @csrf

                        {{-- UNIT --}}
                        <div class="form-floating mb-3">
                            <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror">
                                <option value="">-- Pilih Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" 
                                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Unit Guru</label>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA --}}
                        <div class="form-floating mb-3">
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror"
                                   name="nama" value="{{ old('nama') }}" placeholder="Nama Guru">
                            <label>Nama Guru</label>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- KELAS --}}
                        <div class="form-floating mb-3">
                            <input type="text" 
                                   class="form-control @error('kelas') is-invalid @enderror"
                                   name="kelas" value="{{ old('kelas') }}" placeholder="Kelas">
                            <label>Kelas</label>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- MAPEL --}}
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control @error('mapel') is-invalid @enderror"
                                   name="mapel" value="{{ old('mapel') }}" placeholder="Mapel">
                            <label>Mata Pelajaran</label>
                            @error('mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- USERNAME --}}
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username') }}" placeholder="Username">
                            <label>Username</label>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" value="{{ old('password') }}" placeholder="Password">
                            <label>Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('guru.index') }}" class="btn btn-secondary px-4">
                                Kembali
                            </a>

                            <button class="btn btn-primary px-4">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<script>
    Swal.fire({
        title: "Validasi Gagal!",
        html: `{!! implode('<br>', $errors->all()) !!}`,
        icon: "error",
        confirmButtonText: "OK",
        background: "#fff",
        iconColor: "#e63946",
        confirmButtonColor: "#0d6efd",
        width: 420,
        customClass: {
            popup: 'rounded-4'
        }
    });
</script>
@endif
@endpush
