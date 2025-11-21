@extends('layouts.admin')

@section('content')
    <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0" style="color: #fff">Tambah Unit Baru</h5>
                </div>

                <form action="{{ route('unit.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Input Nama Unit --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Unit</label>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   placeholder="Nama Unit" 
                                   value="{{ old('nama') }}" 
                                   >

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('unit.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection