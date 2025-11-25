type="hidden"@extends('layouts.admin')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <a href="{{ route('response.create') }}" class="btn btn-primary mb-3">+ Tambah Response</a> --}}

                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "{{ session('success') }}"
                        });
                    </script>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered" id="response-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>Nama Siswa</th>
                            <th>Unit</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </section>
@endsection

@push('prepend-style')
    <style>
        .btn-modern {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            transition: 0.25s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* EDIT */
        .btn-edit {
            background: linear-gradient(135deg, #ffcf33, #ffb300);
            color: #000;
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, #ffe066, #ffc533);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 200, 0, 0.5);
        }

        /* HAPUS */
        .btn-delete {
            background: linear-gradient(135deg, #ff4d4d, #e60026);
            color: #fff;
        }
        .btn-delete:hover {
            background: linear-gradient(135deg, #ff6666, #ff1a40);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 50, 0.5);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.bootstrap5.css">
@endpush

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#response-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/sortByEle') }}",
            columnDefs: [
                { width: "50px", targets: 0 },        // Kolom No
                { width: "200px", targets: 2, className: "text-center" }, // Aksi
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'guru_nama', name: 'guru_nama' },
                { data: 'siswa_nama', name: 'siswa_nama' },
                { data: 'unit', name: 'unit' },
                { data: 'kelas', name: 'kelas' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 1600,
                showConfirmButton: false,
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.btn-hapus', function () {

            let id = $(this).data('id');

            Swal.fire({
                title: "Yakin hapus?",
                text: "Data ini tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e60026",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "/admin/response/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (res) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#response-table').DataTable().ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire("Gagal!", "Terjadi kesalahan.", "error");
                        }
                    });

                }

            });

        });
    </script>
@endpush