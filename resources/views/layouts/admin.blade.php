<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')
</head>

<body>
    <div id="app">
        @include('includes.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @yield('content')

            @include('includes.footer')
        </div>
    </div>
    
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
</body>

</html>