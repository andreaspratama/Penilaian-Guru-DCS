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

                        {{-- USERNAME --}}
                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username', $guru->username) }}" placeholder="Username">
                            <label>Username</label>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-floating mb-3">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                placeholder="Password">
                            <label>Password (kosongkan jika tidak diubah)</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6 class="mb-3">📚 Mapel & Kelas</h6>

                        <div id="mapel-wrapper">

                        @foreach ($guru->mapelKelas as $item)
                            <div class="row mb-2 mapel-item">
                                <div class="col-md-5">
                                    <input type="text" name="mapel[]" class="form-control" value="{{ $item->mapel }}">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="kelas[]" class="form-control" value="{{ $item->kelas }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusMapel(this)">
                                        ❌
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        </div>

                        <button type="button" onclick="tambahMapel()" class="btn btn-sm btn-outline-primary mt-2">
                            ➕ Tambah Mapel
                        </button>

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

@push('addon-script')
<script>
    function tambahMapel() {
        let html = `
        <div class="row mb-2 mapel-item">
            <div class="col-md-5">
                <input type="text" name="mapel[]" class="form-control" placeholder="Mapel">
            </div>
            <div class="col-md-5">
                <input type="text" name="kelas[]" class="form-control" placeholder="Kelas">
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="hapusMapel(this)">
                    ❌
                </button>
            </div>
        </div>`;

        document.getElementById('mapel-wrapper').insertAdjacentHTML('beforeend', html);
    }

    function hapusMapel(button) {
        button.closest('.mapel-item').remove();
    }
</script>
@endpush
