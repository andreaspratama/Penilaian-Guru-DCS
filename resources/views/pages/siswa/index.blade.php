<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pilih Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fa;
        }

        .card-select:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .card-select {
            transition: 0.2s ease-in-out;
            cursor: pointer;
        }

        .header-bar {
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-bar .user-info {
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- Header -->
<div class="header-bar">
    <div class="user-info">
        Welcome, {{ Auth::user()->name }}
    </div>
    <div>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
        </form>
    </div>
</div>

<!-- Card Container -->
<div class="container" style="max-width: 600px;">
    <div class="card shadow border-0 p-4">

        <h3 class="text-center mb-3 fw-bold">Choose Teacher</h3>

        <p class="text-center text-muted" style="font-size: 14px;">
            Please select the teacher you would like to evaluate.
        </p>

        <form action="{{ route('penilaianForm') }}" method="GET">

            <div class="mb-3">
                <label class="form-label fw-semibold">Teacher</label>
                <select name="guru_id" class="form-select form-select-lg" required>
                    <option value="">-- Choose Teacher --</option>

                    @foreach ($gurus as $g)
                        <option value="{{ $g->id }}">
                            {{ $g->nama }} — {{ $g->mapel }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button class="btn btn-primary w-100 py-2 fw-semibold">
                Start the assessment
            </button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

</body>
</html>
