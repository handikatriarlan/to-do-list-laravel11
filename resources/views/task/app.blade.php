<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi To Do List dengan Laravel 11">
    <meta name="author" content="handikatriarlan">

    <!-- Title -->
    <title>To-Do-List</title>

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="d-flex flex-column h-100">
    <!-- Header -->
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top bg-primary shadow">
            <div class="container">
                <span class="navbar-brand text-white">
                    <img src="{{ asset('images/brand-laravel.svg') }}" class="align-top me-2" width="30" alt="Logo">
                    Aplikasi To Do List dengan Laravel 11
                </span>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-shrink-0">
        <div class="container pt-5">
            <!-- judul halaman -->
            <h2 class="text-center mt-5 mb-4"><i class="bi bi-pencil-square me-2"></i> To-Do-List</h2>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                        <!-- menampilkan pesan berhasil -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible rounded-4 fade show mb-4" role="alert">
                                <h5 class="alert-heading"><i class="bi bi-check-circle-fill me-1"></i> Success!</h5>
                                <p class="mb-0">
                                    {{ session('success') }}
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- menampilkan pesan kesalahan -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible rounded-4 fade show mb-4" role="alert">
                                <h5 class="alert-heading"><i class="bi bi-x-circle-fill me-1"></i> Failed!</h5>
                                <p class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- form input data -->
                        <form action="{{ route('task.store') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="task" class="form-control" placeholder="Add new task" value="{{ old('task') }}" autocomplete="off">
                                <label>Tambahkan Tugas Baru</label>
                            </div>

                            <div class="pt-3 mt-4 border-top">
                                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                                    <!-- button simpan data -->
                                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                    <!-- button reset data -->
                                    <button type="reset" class="btn btn-secondary px-4">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-4 shadow-sm p-4 mb-5">
                        <!-- form pencarian data -->
                        <form action="{{ route('task') }}" method="GET">
                            <div class="input-group mb-4">
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Silakan masukkan kata kunci...">
                                <!-- button cari data -->
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>

                        <ul class="list-group mb-4">
                            @forelse ($data as $item)
                                <!-- jika data ada, tampilkan data -->
                                <li class="list-group-item d-flex align-items-start p-3">
                                    <div class="flex-grow-1">
                                        {!! $item->is_done == '1' ? '<del>' : '' !!}
                                        {{ $item->task }}
                                        {!! $item->is_done == '1' ? '</del>' : '' !!}
                                    </div>
                                    
                                    <div class="ms-4 d-flex">
                                        <!-- button form ubah data -->
                                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- button hapus data -->
                                        <form action="{{ route('task.destroy', ['id' => $item->id]) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin?')">
                                            @csrf
                                            @method('delete')

                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>

                                <li class="list-group-item collapse py-4" id="collapse-{{ $loop->index }}">
                                    <!-- form ubah data -->
                                    <form action="{{ route('task.update', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('put')

                                        <div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="task" value="{{ $item->task }}" autocomplete="off">
                                                <!-- button ubah data -->
                                                <button class="btn btn-primary" type="submit">Perbarui</button>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="radio px-2">
                                                <label>
                                                    <input type="radio" value="1" name="is_done" {{ $item->is_done == '1' ? 'checked' : '' }}> Selesai
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" value="0" name="is_done" {{ $item->is_done == '0' ? 'checked' : '' }}> Belum
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @empty
                                <!-- jika data tidak ada, tampilkan pesan data tidak tersedia -->
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <div>Tidak ada data yang tersedia.</div>
                                </div>
                            @endforelse
                        </ul>
                        <!-- pagination -->
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto bg-white shadow py-4">
        <div class="container">
            <!-- copyright -->
            <div class="copyright text-center mb-2 mb-md-0">
                &copy; 2024 - <a href="https://github.com/handikatriarlan" target="_blank" class="text-brand text-decoration-none">handikatriarlan</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>